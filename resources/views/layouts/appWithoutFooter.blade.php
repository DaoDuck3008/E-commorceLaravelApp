<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>

    <!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Font Awesome CSS -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    <!-- HomePage CSS -->
    @vite('resources/scss/app.scss')
    
    @vite('resources/scss/product.scss')
</head>
<body>
    {{-- Header --}}
    @include('layouts.header')

    <div style="position: fixed; top:0 ; right:0; z-index:100">
      @include('components.notice')
    </div>

    {{-- body --}}
      <main class="container bg-light my-2">
        @yield('content')
      </main>

    
    @yield('script')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>