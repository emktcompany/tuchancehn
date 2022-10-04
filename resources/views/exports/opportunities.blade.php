<table>
  <thead>
    <tr>
      <th colspan="16">Oferentes</th>
      <th colspan="12">Oferentes</th>
    </tr>
    <tr>
      <th>Nombre</th>
      <th>Categoría</th>
      <th>Fecha</th>
      <th>Estado</th>
      <th>Conexiones</th>
      <th>Conexiones Aceptadas</th>
      <th>Permite recepción de información</th>
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
      <th>Afiliacion</th>
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
        <td>{{ array_get($item, 'name', 'n/a') }}</td>
        <td>{{ array_get($item, 'category.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'created_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'human_status', 'n/a') }}</td>
        <td>{{ array_get($item, 'connections', 'n/a') }}</td>
        <td>{{ array_get($item, 'accepted_connections', 'n/a') }}</td>
        <td>{{ array_get($item, 'allow_apply', 'n/a') }}</td>
        <td>{{ array_get($item, 'begin_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'finish_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'summary', 'n/a') }}</td>
        <td>{{ array_get($item, 'description', 'n/a') }}</td>
        <td>{{ array_get($item, 'requirements', 'n/a') }}</td>
        <td>{{ array_get($item, 'characteristics', 'n/a') }}</td>
        <td>{{ array_get($item, 'country.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'state.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'city.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.name_bidder', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.created_at', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.summary', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.description', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.phone', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.cell_phone', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.services', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.web', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.user.email', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.country.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.state.name', 'n/a') }}</td>
        <td>{{ array_get($item, 'bidder.city.name', 'n/a') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
