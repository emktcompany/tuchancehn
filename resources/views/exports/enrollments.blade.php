<table>
  <thead>
    <tr>
      <th colspan="3">Solicitud</th>
      <th colspan="11">Oportunidad</th>
      <th colspan="13">Candidato</th>
    </tr>
    <tr>
      <th>Fecha</th>
      <th>Aceptada</th>
      <th>Completada</th>
      <th>Nombre</th>
      <th>Fecha</th>
      <th>Disponible desde</th>
      <th>Disponible hasta</th>
      <th>Resumen</th>
      <th>Descripción</th>
      <th>Requisitos</th>
      <th>Características</th>
      <th>País</th>
      <th>Departamento</th>
      <th>Ciudad</th>
      <th>Nombre</th>
      <th>Email</th>
      <th>Afiliacion</th>
      <th>Resumen</th>
      <th>Permiso para conducir</th>
      <th>Lengua Materna</th>
      <th>Otros Idiomas</th>
      <th>Género</th>
      <th>Teléfono</th>
      <th>Celular</th>
      <th>País</th>
      <th>Departamento</th>
      <th>Ciudad</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
      <tr>
        <td>{{ array_get($item, 'created_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'is_accepted', 'n/a') }}</td>
        <td>{{ array_get($item, 'is_fullfilled', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.created_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.begin_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.finish_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.summary', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.description', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.requirements', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.characteristics', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.country.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.state.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity.city.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.user.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.user.email', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.created_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.summary', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.driver_license', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.native_language', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.others_language', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.gender', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.phone', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.cell_phone', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.user.country.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.user.state.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'candidate.user.city.name', 'n/a') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
