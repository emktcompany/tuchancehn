export default [
  {
    for: 'Candidato',
    event: 'candidate/created',
    name: 'Candidato recién registrado'
  },
  {
    for: 'Candidato',
    event: 'candidate/no-login',
    name: 'Candidato sin ingresar a TuChance luego de registrarse'
  },
  {
    for: 'Candidato',
    event: 'candidate/opportunities',
    name: 'Nuevas oportunidades de acuerdo a los intereses del candidato (Consolidado)'
  },
  {
    for: 'Candidato',
    event: 'candidate/incomplete',
    name: 'Candidato completó registro pero no completó perfil (3 momentos) '
  },
  {
    for: 'Candidato',
    event: 'candidate/enrollments/none',
    name: 'Inicia sesión regularmente pero no ha enviado información a ninguna oportunidad'
  },
  {
    for: 'Candidato',
    event: 'candidate/enrollments/accepted',
    name: 'Envío de información aceptado'
  },
  {
    for: 'Candidato',
    event: 'candidate/enrollments/created',
    name: 'Candidato que envió información a alguna oportunidad, de agradecimiento'
  },
  {
    for: 'Candidato',
    event: 'candidate/enrollments/rejected',
    name: 'Correo de información sobre si su solicitud fue aceptada o rechazada'
  },
  {
    for: 'Oferente',
    event: 'bidder/created',
    name: 'Al momento del registro'
  },
  {
    for: 'Oferente',
    event: 'bidder/accepted',
    name: 'Registro aceptado'
  },
  {
    for: 'Oferente',
    event: 'bidder/rejected',
    name: 'Registro rechazado'
  },
  {
    for: 'Oferente',
    event: 'bidder/no-login',
    name: 'Registro aceptado pero no ha iniciado sesión'
  },
  {
    for: 'Oferente',
    event: 'bidder/opportunities/none',
    name: 'Registro aceptado pero no ha publicado oportunidad'
  },
  {
    for: 'Oferente',
    event: 'bidder/opportunities/created',
    name: 'Cuando publica una oportunidad'
  },
  {
    for: 'Oferente',
    event: 'bidder/opportunities/down',
    name: 'Cuando el admin le da de baja a una oportunidad '
  },
  {
    for: 'Oferente',
    event: 'bidder/enrollments/created',
    name: 'Nueva información de candidato recibida para oportunidad'
  },
  {
    for: 'Oferente',
    event: 'bidder/enrollments/pending',
    name: 'Información de candidatos recibida, pero acepta/rechaza ninguna (seguimiento pendiente de las solicitudes por aceptar o rechazar)'
  },
  {
    for: 'Oferente',
    event: 'bidder/opportunities/empty',
    name: 'No tiene oportunidades activas por más de 15 días'
  },
  {
    for: 'Administrador',
    event: 'admin/bidders/created',
    name: 'Nuevo registro de oferente'
  },
  {
    for: 'Administrador',
    event: 'admin/bidders/pending',
    name: 'Registro de oferente pendiente de validación'
  },
  {
    for: 'Administrador',
    event: 'admin/contact',
    name: 'Formulario de contacto (Comunícate con nosotros)'
  }
];
