<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>#TuChance</title>
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Dosis:300,400,700|Open+Sans:300,600,700');
    @import url('{{ asset('css/app.css') }}');
  </style>
</head>
<body class="font-sans">
  <div id="app">
    <div class="fixed pin bg-blue flex items-center justify-center">
      <svg width="64" height="64" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#F05C5E"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".25" cx="18" cy="18" r="18"></circle> <path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(307.444 18 18)"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.8s" repeatCount="indefinite"></animateTransform></path></g></g></svg>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/manifest.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/vendor.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/client.js') }}"></script>
</body>
</html>
