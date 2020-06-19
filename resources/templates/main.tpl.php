    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">Quotes API</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>

    <main role="main" class="container">

      <div id="pyh-home-container">
        <h1>Quotes API</h1>
        <p class="lead">Hundreds of free inspirational quotes to improve your self confidence!</p>

		<h4>Pick an author from the list and view a quote</h4>

		<select id="author-select">
			<option name="">---</option>
    		<?php  foreach ($authors as $k => $author) : ?>
    			<option name="<?php print $k; ?>"><?php print $author; ?></option>
    		<?php endforeach; ?>
		</select>
		<div id="author-spinner" class="spinner-border spinner-border-sm" role="status">
  			<span class="sr-only">Loading...</span>
		</div>

		<div id="quote"></div>

		<div id="error-message"></div>
      </div>

    </main>