<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body onload="productList()">
    <div class="container">
        <div id="product"></div>
    </div>
    <img src=" " height="" alt="">
    <script>
        let data;
        label = ['รหัสสินค้า', 'รูป', 'ชื่อ', 'จำนวน', 'ราคา'];

        function productList() {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                text = "";
                if (this.readyState == 4 && this.status == 200) {
                    data = JSON.parse(this.responseText);
                    console.log(data);
                    text += "<div class='row'>";
                    for (i = 0; i < data.length; i++) {
                        text += "<div class='column'>";
                        text += "<div class='card'>";
                        text += "<img src='" + data[i].image + "' width='5%' height='5%'><br>";
                        text += data[i].name + "<br>";
                        text += "฿ " + data[i].price + " <input type='number' name='' id='" + i + "' size='4' max='" + data[i].stock + "' min='1' value='1'>";
                        text += " <button onclick='add_product(" + data[i].id + "," + i + ")'>Add to Cart</button>";
                        text += "</div>";
                        text += "</div>";
                    }
                    text += "</div>";
                    document.getElementById("product").innerHTML = text;

                }
            }
            xhttp.open("GET", "rest.php?productList", true);
            xhttp.send();

        }
    </script>
</body>

</html>