<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\WardJob;

class ProcessImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sessionId;
    protected $filePath;
    protected $id;
    protected $idProvince;

    /**
     * Create a new job instance.
     */
    public function __construct(int $sessionId, string $filePath, $id = null, $idProvince)
    {
        $this->sessionId = $sessionId;
        $this->filePath = $filePath;
        $this->id = $id;
        $this->idProvince = $idProvince;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::update("
            UPDATE import_sessions
            SET status = ?, queued_at = ?
            WHERE id = ?
        ", ['Đang xử lý', now(), $this->sessionId]);

        try {
            $import = new ExcelImport($this->sessionId);
            Excel::import($import, $this->filePath);

            if ($this->id) {
                DB::statement("
                    UPDATE excel_import 
                    SET ward_id = ?
                    WHERE session_id = ?
                ", [$this->id, $this->sessionId]);
            }

            $namDieuTraRow = DB::selectOne("
                SELECT DISTINCT nam_dieu_tra 
                FROM excel_import
                WHERE session_id = ?
                LIMIT 1
            ", [$this->sessionId]);

            if ($namDieuTraRow && $namDieuTraRow->nam_dieu_tra) {
                DB::delete("
                    DELETE FROM excel_import
                    WHERE ward_id = ? 
                      AND nam_dieu_tra = ? 
                      AND session_id !=  ?
                ", [$this->id, $namDieuTraRow->nam_dieu_tra, $this->sessionId]);
            }

            $totalSuccess = DB::selectOne("
                SELECT COUNT(*) as total
                FROM excel_import
                WHERE session_id = ?
            ", [$this->sessionId])->total;

            $totalFail = $import->failCount;

            $namDieuTraRow = DB::selectOne("
                SELECT DISTINCT nam_dieu_tra 
                FROM excel_import
                WHERE session_id = ?
                LIMIT 1
            ", [$this->sessionId]);

            $namDieuTra = $namDieuTraRow ? $namDieuTraRow->nam_dieu_tra : null;

            DB::update("
                UPDATE import_sessions
                SET nam_dieu_tra = ?, status = ?, result = ?, total_success = ?, total_fail = ?, executed_at = ?
                WHERE id = ?
            ", [$namDieuTra, 'Xử lý thành công', 'Thành công', $totalSuccess, $totalFail, now(), $this->sessionId]);

            if ($namDieuTraRow && $namDieuTraRow->nam_dieu_tra) {
                WardJob::dispatchSync($this->id, $this->idProvince, $namDieuTraRow->nam_dieu_tra);
            }

        } catch (Exception $e) {
            DB::update("
                UPDATE import_sessions
                SET status = ?, result = ?, executed_at = ?
                WHERE id = ?
            ", ['Xử lý thất bại', 'Thất bại', now(), $this->sessionId]);

            throw $e;
        }
    }
}
