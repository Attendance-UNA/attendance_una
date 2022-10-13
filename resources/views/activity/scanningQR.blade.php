<!DOCTYPE html>
<html lang="en">

<head>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Attendance List</title>
  <!-- Font Awesome icons (free version)-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet">
  <!-- Fonts CSS-->
  <link rel="stylesheet" href="css/heading.css">
  <link rel="stylesheet" href="css/body.css">
  <link rel="stylesheet" type="text/css" href="{{asset('css/loading.css')}}">
  <script src="js/activity/activityFunctions.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>

<body id="page-top" onload="initializerEventListener()">
  <div class="loading">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
  </div>
  <script src="/js/html5-qrcode.min.js"></script>
  <section class="page-section portfolio" style="padding-top: 2rem;" id="scanningCode">
    <div class="container" id="QR-Code" style="margin-top: 0rem;">
      <div class="row justify-content-center">
        <div class="col-md-6">

          <div id="reader"></div>

        </div>
        <div class="col-md-6">
          <h4>Escanee su c&oacute;digo QR para registrar su asistencia.</h4>
          <div class="form-group">
            <label for="activityName">Nombre de la actividad:</label>
            <input type="text" name="activityName" class="form-control" id="activityName" value="{{$newActivity->name}}" readonly="true">
          </div>
          <div class="form-group">
            <label for="activityDescription">Descripci&oacuten de la actividad:</label>
            <input type="text" name="activityDescription" class="form-control" id="activityDescription" value="{{$newActivity->description}}" readonly="true">
          </div>
          <div class="form-group">
            <label for="activityManagername">Nombre del encargado:</label>
            <input type="text" name="activityManagername" class="form-control" id="activityManagername" value="{{$newActivity->manager}}" readonly="true">
          </div>
          <div class="form-group">
            <label>Fecha y Hora de Inicio: {{$newActivity->date}} {{$newActivity->startTime}}</label>
            <input type="hidden" name="activityDate" class="form-control" id="activityDate" value="{{$newActivity->date}}" readonly="true">
            <input type="hidden" name="activityStartTime" class="form-control" id="activityStartTime" value="{{$newActivity->startTime}}" readonly="true">
            <input type="hidden" name="idGuest" class="form-control" id="idGuest" value="">
          </div>
        </div>

      </div>

      <div class="panel-footer">
      </div>
      <div class="container h-100">
        <!-- Contains the subcategories in a table -->
        @include('activity/guestsTable')
      </div>
      
      <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
      <div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
      <!-- Bootstrap core JS-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
      <!-- Third party plugin JS-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
      <!-- Core theme JS-->
      <script src="js/scripts.js"></script>


  </section>
  </div>

</body>

</html>