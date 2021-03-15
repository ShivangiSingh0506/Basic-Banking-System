<!DOCTYPE html>
<html>
  <head>
    <style>
  body {
    background-image: url(images/Capture.PNG);
  }

  div {
    width: 50%;
    height: 50%;
    opacity: 0.9;

  }

  input[type=text],
  select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  button {
    width: 100%;
    background-color: #549fe6;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  input[type=submit]:hover {
    background-color: #187edd;
  }

  div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
  }
  </style>
<?php include 'connection.php'; ?>
</head>

<body>

  <h3>Transfer Money</h3>

  <div>
    <form method="POST">
      <label for="fname">Sender's Name</label>
      <input type="text" id="fname" name="name1" value="<?php //echo $arrdata['Name']; //?>" required
        placeholder="Your name..">

      <label>Email ID:</label>
      <input type="text" name="Email1" value="<?php //echo $arrdata['Email']; ?>" required
        placeholder="Your email.. " /><br><br>

      <label>Amount:</label>
      <input type="text" name="amount1" value="" style="width:210px;" required placeholder="Enter amount" /><br>

      <label for="lname">Reciever's Name</label>
      <input type="text" id="lname" name="name2" placeholder="Reciever's name..">

      <label>Email ID:</label>
      <input type="text" name="Email2" value="" required placeholder="Enter Email" /><br><br>

      <button name="submit">Transfer</button>
    </form>
  </div>
  <?php


if(isset($_POST['submit']))
{
    
  
    $Sender_name=$_POST['name1'];
    $Sender_account=$_POST['Email1'];
    $Sender=$_POST['amount1'];
    $Receiver_name=$_POST['name2'];
    $Receiver_account=$_POST['Email2'];
     
  

    $ids=$_GET['idtransfer'];
    $senderquery="select * from `customerdetails` where `Email`='$ids' ";
    $senderdata=mysqli_query($con,$senderquery);
  
    if (!$senderdata) {
     printf("Error: %s\n", mysqli_error($con));
    exit();
    }

    $arrdata=mysqli_fetch_array($senderdata);

    //receiverquery
    $receiverquery="select * from `customerdetails` where `Email`='$Receiver_account'";
    $receiver_data=mysqli_query($con,$receiverquery);
   
    if (!$receiver_data) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
    }
    $receiver_arr=mysqli_fetch_array($receiver_data);
    $id_receiver=$receiver_arr['Email'];


    if($arrdata['Balance'] >= $Sender)
    {  

      $decrease_sender=$arrdata['Balance'] - $Sender;
      $increase_receiver=$receiver_arr['Balance'] + $Sender;
       $query="UPDATE `customerdetails` SET `Email`='$ids',`Balance`= $decrease_sender  where `Email`='$ids' ";
       $rec_query="UPDATE `customerdetails` SET `Email`='$id_receiver',`Balance`= $increase_receiver where  `Email`='$id_receiver'";
       $res= mysqli_query($con,$query);
       $rec_res= mysqli_query($con,$rec_query);
       if($res && $rec_res)
       {
       ?>
  <script>
    swal("Done!", "Transaction Successful!", "success");
  </script>

  <?php
   
      }
      else
      {
      ?>
  <script>
    swal("Error!", "Error Occured!", "error");
  </script>

  <?php
      
      }
    }
  

  else
 {
  ?>
  <script>
    swal("Insufficient Balance", "Transaction Not  Successful!", "warning");
  </script>
  <?php
   
 }
 
}
?>





</body>

</html>