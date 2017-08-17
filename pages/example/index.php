<!DOCTYPE html>
<html>
<head>

</head>
<body>
  <h1><?php echo($data['title']); ?></h1>
  <h4><?php echo($data['description']); ?></h4>
  <br>
  <?php foreach($data['records'] as $record) {
    echo("<p>ID: ".$record['id']."  Name: ".$record['name']."</p>");
  }
  ?>
</body>
</html>
