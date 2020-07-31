<?php
	//open connection
	$connection = mysqli_connect("localhost", "root", "root", "biden", "3306");
	
	if (mysqli_connect_errno()) {  
	     echo "Connection to database failed.";
	    
	    exit;
	 }
	$connection->set_charset("utf8");

	//prepare statement
	$stmt = $connection->prepare("CALL get_article_nav (?);");
	$stmt->bind_param("i", $par_id);

	//set parameters
	$par_id = $_GET["id"];

	//execute statement
	if(!$stmt->execute()) {

	    if (isset($connection)) mysqli_close($connection);

	    echo "Retrieve from database failed.";
	    
	    exit;
	}

	//getting result
	$result = $stmt->get_result();
	
	$prev_id = 0;
	$next_id = 0;
	$html_code = "";
	
	while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            $prev_id = $row[0];
	$next_id = $row[1];
	$html_code = $row[7];
        }

	//close connection
	if (isset($connection)) mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, noarchive">
    <meta name="format-detection" content="telephone=no">
    <title>United for Biden</title>
    <link rel="icon" href="media/favicon.ico">
    <link href="styles/reset.css" rel="stylesheet">
    <link href="styles/fonts.css" rel="stylesheet">
    <link href="styles/main.css" rel="stylesheet">
    <style>
        .edit {
            position: relative;
            width: 100%;
	padding: 0 20px;
        }
        .editRight {
            width: 30%;
            height: 100%;
            position: absolute;
            top: auto;
            right: 0;
            overflow: auto;
	background: #EE5253;
        }
        .editRight div {
	padding: 10px;
        }
        .editLeft {
            width:  70%;
	min-height: 800px;
	padding: 20px 0;
	box-sizing: border-box;
        }
        body a {
	text-decoration: none;
        }
    </style>
</head>
<body>
    <nav id="Menu" class="hidden">
        <div class="content">
            <ul>
                <li>
                    <a href="index.html"><img src="media/logo.png" alt="Biden War Room"></a>
                    <a href="#!" onclick="showMenu();">☰</a>
                </li>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="about.html">About</a>
                </li>
                <li>
                    <a href="editorial.html" style="color: #E10600;">Editorial</a>
                </li>
                <li>
                    <a href="community.html">Community</a>
                </li>
                <li>
                    <a href="store.html">Store</a>
                </li>
                <li>
                    <a href="portal.html">Portal</a>
                </li>
                <li>
                    <a href="contact.html">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
    <article id="News" class="displayBlock expandy">
        <div class="content">
            <section class="monoCol">
                <div class="edit">
                    <div class="editRight">
		<div>
                        <div>
                            <img src="media/article1.png" style="width: 90%;">
                            <p>Article 1</p>
                            <p><a href="#">READ MORE -&gt;</a></p>
                        </div>
                        <div>
                            <img src="media/article2.png" style="width: 90%;">
                            <p>Article 2</p>
                            <p><a href="#">READ MORE -&gt;</a></p>
                        </div>
                        <div>
                            <img src="media/article3.png" style="width: 90%;">
                            <p>Article 3</p>
                            <p><a href="#">READ MORE -&gt;</a></p>
                        </div>
		</div>
                    </div>
                    <div class="editLeft">
                        <table style="width: 100%;">
                            <tr>
                                <td colspan="2">
			<?php echo $html_code; ?>
		        </td>
                            </tr>
                        </table>
                        <table style="width: 100%; margin: 0 auto;">
                            <tr>
                                <td style="text-align: left; padding: 20px 10%;">
                                    <a href="<?php if ($prev_id > 0) echo "/editorial.php?id=".$prev_id; else echo "#"; ?>" style="">&lt;- PREVIOUS</a>
                                    <p style="">Article 1</p>
			</td>
                                <td style="text-align: right; padding: 10px 10%;">
                                    <a href="<?php if ($next_id > 0) echo "/editorial.php?id=".$next_id; else echo "#"; ?>" style="">NEXT -&gt;</a>
                                    <p style="">Article 2</p>
			</td>
                            </tr>
                        </table>
		<p style="font-weight: bold; margin-top: 20px;">January</p>
		<table style="width: 100%;">
                            <tr>
                                <td style="width: 20%; vertical-align: middle;">
                                    <img src="media/article1.png" style="margin:10px 0; width: 70%;">
			</td>
                                <td style="width: 40%;  vertical-align: middle;">
                                    <p>Title: ____</p>
                                    <p>Desc: ____</p>
			</td>
                                <td style="width: 40%;  vertical-align: middle;">
                                    <p>Author: ____</p>
                                    <p>Date: ____</p>
			</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </article>
    <footer id="Footer">
        <div class="content">
            <p>Copyright&nbsp;©2020 United&nbsp;for&nbsp;Biden</p>
        </div>
    </footer>
    <script>
        function getFirstArea() {
            var firstArea = document.getElementById("Notice");
            
            if (!firstArea.classList.contains("displayNone")) return firstArea;
            
            return document.getElementById("Info");
        }
        
        function showMenu() {
            var menu = document.getElementById("Menu");
            
            var hidden = !menu.classList.contains("hidden");
            var fixed = !hidden || menu.classList.contains("fixed");
            
            menu.classList = ((hidden ? "hidden" : "") + " " + (fixed ? "fixed" : "")).trim();
            
            getFirstArea().style = fixed ? "padding-top: 80px;" : "";
        }
        
        window.onscroll = function() {
            var topOffset = window.pageXOffset !== undefined ? window.pageYOffset : document.documentElement.scrollTop;
            
            document.getElementById("Menu").classList = "hidden" + (topOffset > 0 ? " fixed" : "");
            
            getFirstArea().style = topOffset > 0 ? "padding-top: 80px;" : "";
            
            //if (topOffset > 160) window.scrollBy(0,-80); //navigation covers beginning
        };
        
        (function() {
            function scrollHorizontally(e) {
                e = window.event || e;
                var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
                document.getElementById('banners').scrollLeft -= (delta*40); // Multiplied by 40
                e.preventDefault();
            }
            if (document.getElementById('banners').addEventListener) {
                // IE9, Chrome, Safari, Opera
                document.getElementById('banners').addEventListener("mousewheel", scrollHorizontally, false);
                // Firefox
                document.getElementById('banners').addEventListener("DOMMouseScroll", scrollHorizontally, false);
            } else {
                // IE 6/7/8
                document.getElementById('banners').attachEvent("onmousewheel", scrollHorizontally);
            }
        })();
        
        function showFeatBox(index) {
            var featBoxes = document.getElementById("featMain").getElementsByClassName("featBox");

            for (var i = 0; i < featBoxes.length; i++) featBoxes[i].classList = "featBox" + (i === index ? " featBoxShown" : "");
        }
    </script>
</body>
</html>