<template>
  <div id="app">
  	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
    		<h1>Marktplaats</h1>
    		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    	</div>
    </nav>
    
    <main>
	    <keep-alive>
	    	<router-view></router-view>
	    </keep-alive>
	   </main>
  </div>
</template>

<script> 
export default {  }
</script>