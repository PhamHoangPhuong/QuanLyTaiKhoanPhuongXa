@section('content')
<div class="row d-flex align-items-stretch">
	<!-- Cột phải: Form -->
	<div class="col-md-9">
		<div class="card shadow p-4 h-100">
			<h4 class="mb-4">User Profile</h4>
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="first_name" class="form-label">First Name</label>
					<input type="text" value="{{ $user->first_name }}" class="form-control" readonly>
				</div>
				<div class="col-md-6 mb-3">
					<label for="last_name" class="form-label">Last Name</label>
					<input type="text" value="{{ $user->last_name }}" class="form-control" readonly>
				</div>
				<div class="col-md-6 mb-3">
					<label for="full_name" class="form-label">Full Name</label>
					<input type="text" value="{{ $user->first_name }} {{ $user->last_name }}" class="form-control" readonly>
				</div>
			</div>

			<div class="d-flex justify-content-between mt-4">
				<a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
			</div>
		</div>
	</div>
</div>
@stop