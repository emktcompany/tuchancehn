<table>
  <thead>
    <tr>
      <th colspan="20">Candidato</th>
    </tr>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
      <th>Afiliacion</th>
      <th>Resumen</th>
      <th>Tiene permiso para conducir</th>
      <th>Campo Profesional</th>
      <th>Objetivo Profesional</th>
      <th>Experiencia Profesional</th>
      <th>Educación</th>
      <th>Competencias</th>
      <th>Lengua Materna</th>
      <th>Otros Idiomas</th>
      <th>Referencias</th>
      <th>Género</th>
      <th>Teléfono</th>
      <th>Celular</th>
      <th>Experiencia</th>
      <th>País</th>
      <th>Departamento</th>
      <th>Ciudad</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
      <tr>
        <td>{{ array_get($item, 'user.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'user.email', 'n/a') }}</td>
        <td>{{ array_get($item, 'created_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'summary', 'n/a') }}</td>
        <td>{{ array_get($item, 'driver_license', 'n/a') }}</td>
        <td>{{ array_get($item, 'professional_area', 'n/a') }}</td>
        <td>{{ array_get($item, 'professional_objective', 'n/a') }}</td>
        <td>{{ array_get($item, 'professional_experience', 'n/a') }}</td>
        <td>{{ array_get($item, 'training_education', 'n/a') }}</td>
        <td>{{ array_get($item, 'skills', 'n/a') }}</td>
        <td>{{ array_get($item, 'native_language', 'n/a') }}</td>
        <td>{{ array_get($item, 'others_language', 'n/a') }}</td>
        <td>{{ array_get($item, 'references', 'n/a') }}</td>
        <td>{{ array_get($item, 'gender', 'n/a') }}</td>
        <td>{{ array_get($item, 'phone', 'n/a') }}</td>
        <td>{{ array_get($item, 'cell_phone', 'n/a') }}</td>
        <td>{{ array_get($item, 'years_experience', 'n/a') }}</td>
        <td>{{ array_get($item, 'user.country.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'user.state.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'user.city.name', 'n/a') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
