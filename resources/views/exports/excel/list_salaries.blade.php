<div>
	<center>
		<div>
			Laporan Gaji Perusahaan {{ $company->c_name }}
		</div>
		<div>
			Periode {{ $periods[0]->isoFormat('D MMM YYYY') }} - {{ $periods[1]->isoFormat('D MMM YYYY') }}
		</div>
	</center>
</div>
<p></p>

<table class='table' style="border:black;border-width: 1px;">
	<thead>
		<tr>
			<td style="text-align: center" colspan="6">Laporan Gaji</td>
		</tr>
		<tr>
			<th>Nama</th>
			<th>Gaji</th>

		</tr>
	</thead>
	<tbody>
		@foreach($user_companies as $key => $userCompany)
		<tr>
			<td>{{ $userCompany->user->u_name }}</td>
			<td>{{ $userCompany->salaries[0]->net_sallary ?? 0 }}</td>
		</tr>
		@endforeach
	</tbody>
</table>