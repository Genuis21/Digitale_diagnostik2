<!--Including the header -->
<?php
		$title = "Health news";
		include "header.php";
		?>
	
<!--Page body -->

<body class="body">
	<h1 class="body-content">Health news</h1> 
    <!--Adding some description text on digital consultation-->
    <p class="body-content">Everything you need to know about the actual health news with no need to subscribe to any page.</p>
      
    </p>
    
    <?php 
    $api = file_get_contents("https://newsapi.org/v2/top-headlines?country=de&category=health&apiKey=7aee407b781d42a297365272aa39090a");
    $news = json_decode($api, true);
    //print_r($news);
    ?>    
    
    <!--<table align="center" width="1033" border="1" class="newsdisplay"> -->
    <table width="100%" style="padding-left: 10%; padding-right: 20%;" >
      <tr>
        <!--<td colspan="2"><h1>Health news</h1></td> -->
        <!--<td colspan="2"><h1>&nbsp;</h1></td> -->
      </tr>
           
      <?php foreach($news['articles'] as $value) {?>
        <tr style="background: #fae8d6;">
          <td><img src="<?=$value['urlToImage']?>" style="height:120px; width: 120px; border-radius: 10%;"/></td>
          <!--<td><div style="padding: 10px;"> -->
          <td style="padding: 10px;">
            <div>
            <p><b><?=$value['title']?></b></p>
            <p><?=$value['publishedAt']?></p>
            <p><?=$value['description']?></p>
            <a href="<?=$value['url']?>" style="color:#04946d;">Read more ...</a>
            </div>
          </td>
        </tr>
      <?php } ?>
    </table>
</body>

<!--Including the footer --> 
<?php
	include "footer.php";
	?>
