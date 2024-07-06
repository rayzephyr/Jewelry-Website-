<html>
    <head>
        <link rel="stylesheet" href="product_style.css">
    </head>
<?php
 session_start();
 
 include 'connection.php';
 if(isset($_POST['id'])){
        $a = $con->prepare("select * from cart where id = ? and pid = ? ");
        $a->bind_param('ii',$_SESSION['id'],$_POST['id']);
        $a->execute();
        $b = $a->get_result();
        $c = $b->fetch_assoc();
        if($c){
            echo 'Product already in cart';
        }else{
            $d = $con->prepare("insert into cart (id,pid,quantity) values (?,?,?)");
            $d->bind_param('iii',$_SESSION['id'],$_POST['id'],$_POST['quantity']);
            $d->execute();
            echo "Product added to cart";
        }
 }
 elseif(isset($_POST['delete'])){
    $a = $con->prepare("delete from cart where id = ? and pid = ? ");
    $a->bind_param('ii',$_SESSION['id'],$_POST['delete']);
    $a->execute();
    echo "Product removed from cart";
    header("Location: cart.php");
    exit();
 }else{
        echo "<h1> Welcome to Cart </h1>";
        $a = $con->prepare("select * from cart where id = ? ");
        $a->bind_param('i',$_SESSION['id']);
        $a->execute();
        $b = $a->get_result();
        
        $c = [];
        $total_price = 0; // Initialize total price variable

    while($row = $b->fetch_assoc()) {
        $c[] = $row;
    }
    if(empty($c)){
        echo "Cart is empty";
    } else {
        foreach ($c as $row) {
            $d = $con->prepare("select * from products where pid = ? ");
            $d->bind_param('i',$row['pid']);
            $d->execute();
            $e = $d->get_result();
            $f = $e->fetch_assoc();
            $product_total = $f['price'] * $row['quantity']; // Calculate total for this product
            $total_price += $product_total; // Add to total price
            
            ?>
            <div class='product'>
            <h3><?php echo $f['pname']?></h3>
            <p> Quantity: <?php echo $row['quantity']?></p>
            <p>Price: <?php echo $f['price']?></p>
            <p>Total: <?php echo $product_total?></p>
                    
            <form method="post" action="cart.php">
                <input type="hidden" name="pid" value="<?php echo $f['pid'] ?>">
          
            </form>
        </div>
            <div class="quantity">
                <form  method="post" action="cart.php">
                <input type="hidden" name="delete" value="<?php echo $f['pid'] ?>">
                <button type="submit" >Remove</button>
                </form>
            </div>
            <?php
               }
            }
            ?>
             <div class="total-price">
                <h2>Total Price: <?php echo $total_price; ?></h2>
            </div>
            <div class="confirm-container">
                <form method="post" action="ty.html">
                    <button type="submit" class="confirm-button">Confirm</button>
                </form>
            </div>
            
            <?php
        }
        ?>
               
        
    



            
