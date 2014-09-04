<?php 
include( 'process.php' );
$process = new Process(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rotten Tomatoes Application</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div id="wrap">
		<div id="left">
			<h2 class="title">Search Movies</h2>
			<form action="#" method="GET">
				
				<?php $colors = array( 'red', 'green', 'blue', 'yellow' ); ?>
				<?php $q = ( isset( $_GET['q'] ) ? $_GET['q'] : 'red' ); ?>
				<?php $p = ( isset( $_GET['p'] ) ? $_GET['p'] : 1 ); ?>

				<?php foreach( $colors as $color ): ?>
					<span class="input_block">
						<input type="radio" name="q" id="<?php echo $color; ?>" value="<?php echo $color; ?>"<?php echo ( isset( $q ) && $q == $color ? ' checked="checked"' : ''); ?>> <label for="<?php echo $color; ?>"><?php echo ucwords($color); ?></label>
					</span>
				<?php endforeach; ?>

				<input type="submit" name="submit" value="Search">

			</form>
		</div><!-- #left -->
		<div id="right">
			<h2 class="title">Movies</h2>

			<?php $results = $process->_request( $q, $p ); ?>

			<?php foreach( $results->movies as $movie ): ?>

				<?php extract( $process->qMatch( $q, $movie->title ) ); ?>

				<div class="movies<?php echo ( $bg_color != null ? ' '.$bg_color : '' ); ?>">

					<img src="<?php echo $movie->posters->original; ?>" alt="">
					<h3>
						<span>Title: </span> 
						<?php echo $movie_title; ?>
					</h3>
					<h3> 
						<span>Year: </span> 
						<?php echo $movie->year; ?>
					</h3>
					<h3>
						<span>Runtime: </span> 
						<?php echo $process->computeRuntime( $movie->runtime ); ?>
					</h3>

				</div><!-- .movies -->

			<?php endforeach; ?>
			
			<ul>
				<?php for( $i=1; $i<=3 ; $i++ ): ?>
				<li<?php echo ( $p == $i ? ' class="active"' : '' ); ?>><a href="?q=<?php echo $q; ?>&amp;p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				<?php endfor; ?>
			</ul>

		</div><!-- #right -->
	</div>
</body>
</html>