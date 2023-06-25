<?php require('includes/config.php'); 

//if not logged in redirect to login page
if (! $user->is_logged_in()){
    header('Location: login.php'); 
    //exit(); 
}

//define page title
$title = 'VetCap Usuarios';

//include header template
require('layout/header.php'); 
?>

<section class="class-offer-area section-padding border-bottom compai">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-12">
              <h4 style="color: black !important; font-size: 27px !important; text-align: center !important; font-family: 'Times New Roman', sans-serif;">Bienvenido/a <?php 
  echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></h4>
              <div
                class="section-tittle d-flex justify-content-between align-items-center"
              >
                <h2>Tus eventos</h2>
                <a
                  class="browse-btn mb-20"
                  ><h3></h3>
                    <p><a style="text-decoration: unset !important;font-weight: 550 !important;" href="logout.php">Cerrar sesión</a></p></a
                >
              </div>
            </div>
          </div>
          <div class="row">
<?php 
/*
$jsonString = $_SESSION['eventsQueryResult'];
$data = json_decode($jsonString, true); // Convert JSON to PHP associative array

// Get and print only the values
$values = array_values($data);
foreach ($values as $value) {
    echo $value . "<br>";
} */

if (isset($_SESSION['eventsQueryResult'])) {


  //updating
$pdo = new PDO('mysql:host=localhost;dbname=daravey', 'root', '');

// Prepare the query
$stmt = $pdo->prepare('SELECT eventsRegistered FROM members WHERE memberID = :memberID');

// Bind the parameter value
$memberID = $_SESSION['memberID'];
$stmt->bindParam(':memberID', $memberID, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->fetch();

// Access the value of eventsRegistered
$eventsRegistered = $result['eventsRegistered'];

$jsonString = $eventsRegistered;
      $datas = json_decode($jsonString, true); // Convert JSON to PHP associative array

      $eventIds = !empty($datas) ? implode(',', $datas) : '';
      $_SESSION['eventIds'] = $eventIds;

      $pdo = new PDO('mysql:host=localhost;dbname=daravey', 'root', '');

      $stmt = $pdo->prepare('SELECT id, name, description, picture FROM events WHERE id IN (' . $eventIds . ')');
      $stmt->execute();

      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $_SESSION['eventsQueryResult'] = $data;

// end updating



    $data = $_SESSION['eventsQueryResult'];
    // Print the values
    foreach ($data as $row) {
      ?>
      <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="properties pb-30">
                <div class="properties__card">
                  <div class="properties__img">
                    <a href="#"
                      ><img src="../assets/img/<?php echo $row['picture']; ?>" alt="<?php echo $row['name']; ?>">
    </a>
                  </div>
                  <div class="properties__caption text-center">
                    <h3>
                      <a
                        class="colornesgrow"
                        href="#"
                        ><?php echo $row['description']?></a
                      >
                    </h3>
                  </div>
                </div>
              </div>
            </div>
<?php
        
    }
} else {
    echo "No tienes eventos registrados";
}

?>
          </div>
        </div>
      </section>




      <div class="container">



                    




                    
         <!--   <?php for($i=0; $i < 2; $i++){ ?>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis veritatis nemo ad recusandae labore nihil iure qui eum consequatur, officiis facere quis sunt tempora impedit ullam reprehenderit facilis ex amet!
            <?php } ?>  -->
            
</div>

<section class="class-offer-area section-padding border-bottom compai">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-12">
              <div
                class="section-tittle d-flex justify-content-between align-items-center"
              >
              
                <h2>Ultimos eventos</h2>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="properties pb-30">
                <div class="properties__card">
                  <div class="properties__img">
                    <a href="#"
                      ><img src="../assets/img/03.jpg" alt="imagen"
                    /></a>
                  </div>
                  <div class="properties__caption text-center">
                    <h3>
                      <a
                        class="colornesgrow"
                        href="#"
                        >El trimming y el stripping son dos técnicas de corte de
                        pelo en perros que consisten en el arrancado parcial y
                        total del cabello.</a
                      >
                    </h3>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="properties pb-30">
                <div class="properties__card">
                  <div class="properties__img">
                    <a href="#"
                      ><img src="../assets/img/04.jpg" alt="imagen"
                    /></a>
                  </div>
                  <div class="properties__caption text-center">
                    <h3>
                      <a
                        class="colornesgrow"
                        href="#"
                        >El hipotiroidismo es el cuadro clínico que se deriva de
                        una reducida actividad de la glándula tiroides.</a
                      >
                    </h3>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="properties pb-30">
                <div class="properties__card">
                  <div class="properties__img">
                    <a href="#"
                      ><img src="../assets/img/05.jpg" alt="imagen"
                    /></a>
                  </div>
                  <div class="properties__caption text-center">
                    <h3>
                      <a
                        class="colornesgrow"
                        href="#"
                        >El síndrome de Cushing aparece cuando el cuerpo tiene
                        demasiada hormona cortisol a lo largo del tiempo. Puede
                        ser el resultado de tomar corticosteroides por vía oral
                        o de que el cuerpo produzca demasiado cortisol.</a
                      >
                    </h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>




<section class="class-offer-area section-padding border-bottom compai">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12">
        <div class="section-tittle d-flex justify-content-between align-items-center">
          <h2>INSCRIBETE</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <form action="insert_event.php" method="POST">
        <label for="event_id">Lista de eventos:</label>
        <?php
          // Retrieve the list of events from the database
          $pdo = new PDO('mysql:host=localhost;dbname=daravey', 'root', '');
          $stmt = $pdo->query('SELECT id, name FROM events');
          $eventList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <select name="event_id" id="event_id">
          <?php foreach ($eventList as $event) : ?>
            <option value="<?php echo $event['id']; ?>"><?php echo $event['name']; ?></option>
          <?php endforeach; ?>
        </select>
        <br>
        <br> <!-- Added line break for spacing -->
        <input type="submit" value="Inscribir">
      </form>
    </div>
  </div>
</section>

<section class="class-offer-area section-padding border-bottom compai">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12">
        <div class="section-tittle d-flex justify-content-between align-items-center">
          <h2>UNSUBSCRIBE</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <form action="unsubscribe_event.php" method="POST">
        <label for="event_id">Event List:</label>
        <?php
          // Retrieve the list of events from the database
          $pdo = new PDO('mysql:host=localhost;dbname=daravey', 'root', '');
          $stmt = $pdo->query('SELECT id, name FROM events');
          $eventList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <select name="event_id" id="event_id">
          <?php foreach ($eventList as $event) : ?>
            <option value="<?php echo $event['id']; ?>"><?php echo $event['name']; ?></option>
          <?php endforeach; ?>
        </select>
        <br>
        <br> <!-- Added line break for spacing -->
        <input type="submit" value="Unsubscribe">
      </form>
    </div>
  </div>
</section>



<?php 
//include header template
require('layout/footer.php'); 
?>