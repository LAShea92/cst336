<!DOCTYPE html>

<?php
    include './dbConnection.php';
    $conn = getDatabaseConnection("ottermart");
    
    function displayCategories(){
        global $conn;
        
        $sql = "SELECT catID, catName from om_category ORDER BY catName";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($records as $record){
            echo "<option value='".$record["catId"]."' >" . $record["catName"] . "</option>";
        }
    }
    
    function displaySearchResults(){
        global $conn;
        
        if(isset($_GET['searchForm'])){
            echo "<h3>Products Found: </h3>";
            
            $namedParameters = array();
            
            $sql = "SELECT * FROM om_product WHERE 1";
            
            if(!empty($_GET['product'])){
                $sql .= " AND productName LIKE :productName";
                $namedParameters[":productName"] = "%" . $_GET['product'] . "%";
                
            }
        }
    }
?>

<html>
    <head>
        <title>OtterMart Product Search</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div>
            <h1> OtterMart Product Search </h1>
        
        <form>
            Product: <input type="text" name="product" />
            <br>
            Category:
                <select name="category">
                    <option value="">Select One</option>
                    <?php displayCategories()?>
                </select>
            <br>
            Price: From <input type="text" name="priceFrom" size="7">
                   To <input type="text" name="priceTo" size="7">
            <br>
            Order result by:
            <br>
            
            <input type="radio" name="orderBy" value="price" /> Price <br>
            <input type="radio" name="orderBy" value="name" /> Name
            
            <br><br>
            <input type="submit" value="Search" name="searchForm" />
        </form>
        
        <br />
        
        </div>
        
        <hr>
    </body>
</html>