<table>
  <thead>
    <tr>
      <th colspan="18">Oferentes</th>
    </tr>
    <tr>
      <th>Nombre</th>
      <th>Afiliacion</th>
      <th>Conexiones</th>
      <th>Conexiones Aceptadas</th>
      <th>Oportunidades</th>
      <th>Oportunidades Publicadas</th>
      <th>Oportunidades En Espera</th>
      <th>Oportunidades Expirada</th>
      <th>Resumen</th>
      <th>Descripción</th>
      <th>Teléfono</th>
      <th>Mobile</th>
      <th>Servicios</th>
      <th>Website</th>
      <th>Email</th>
      <th>País</th>
      <th>Departamento</th>
      <th>Ciudad</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
      <tr>
        <td>{{ array_get($item, 'name_bidder', 'n/a') }}</td>
        <td>{{ array_get($item, 'created_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'enrollment_count', 'n/a') }}</td>
        <td>{{ array_get($item, 'enrollment_accepted_count', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity_count', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity_active_count', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity_upcoming_count', 'n/a') }}</td>
        <td>{{ array_get($item, 'opportunity_expired_count', 'n/a') }}</td>
        <td>{{ array_get($item, 'summary', 'n/a') }}</td>
        <td>{{ array_get($item, 'description', 'n/a') }}</td>
        <td>{{ array_get($item, 'phone', 'n/a') }}</td>
        <td>{{ array_get($item, 'cell_phone', 'n/a') }}</td>
        <td>{{ array_get($item, 'services', 'n/a') }}</td>
        <td>{{ array_get($item, 'web', 'n/a') }}</td>
        <td>{{ array_get($item, 'user.email', 'n/a') }}</td>
        <td>{{ array_get($item, 'country.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'state.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'city.name', 'n/a') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
