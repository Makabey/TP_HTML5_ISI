window.addEventListener("load", function(){
	var  movie = document.getElementById("movie");
	movie.addEventListener('click', function(){
		if(movie.paused){
			movie.play();
		}else{
			movie.pause();
		}
	});
	
	var bouton = document.getElementById("bouton");
	bouton.addEventListener('click', function(){
		if(movie.currentTime >= movie.duration){
			//movie.load();
			movie.currentTime = 0;
			console.log("Retour à 0s");
		}
		movie.currentTime = movie.currentTime + 1;
	});
});