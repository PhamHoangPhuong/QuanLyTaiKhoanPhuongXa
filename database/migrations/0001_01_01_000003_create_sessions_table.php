<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration{

    public function up(){
        Schema::create('import_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_code')->unique();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->year('nam_dieu_tra')->nullable();
            
            $table->foreign('ward_id')->references('ward_id')->on('wards')->onDelete('cascade');
            $table->foreign('province_id')->references('province_id')->on('provinces')->onDelete('cascade');


            $table->enum('status', ['Đang chờ xử lý', 'Đang xử lý', 'Xử lý thành công', 'Xử lý thất bại'])->default('Đang chờ xử lý');
            $table->enum('result', ['Thành công', 'Thất bại'])->nullable();
            $table->integer('total_success')->default(0);
            $table->integer('total_fail')->default(0);
            $table->timestamp('queued_at')->nullable();
            $table->timestamp('executed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('import_sessions');
    }

}