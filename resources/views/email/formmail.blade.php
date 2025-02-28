
<table>

	<tr>
		<td>
			Contact form submission from TinySteps contact page.
		</td>
	</tr>
	
</table>

<table>

	<tr>
		<td>Name: {{ $formEmail->fname }} {{ $formEmail->lname }}</td>
	</tr>
	<tr>
		<td>Email: {{ $formEmail->email }} </td>
	</tr>
	<tr>
		<td>{{ $formEmail->message }}</td>
	</tr>
</table>
