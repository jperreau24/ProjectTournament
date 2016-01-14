$(function() {

  var slideShowInterval = null;
  var speed;                      // Vitesse du défilement
  var currentPosition;            // Position correspodant au numéro d'image actuellement affichée
  var numberOfImg;                // Nombre d'images à afficher
  var slideWidth;                 // Largeur de l'image actuellement affichée (dépend de la taille de la fenêtre du navigateur)
  var pause = 0;                  // Permet de déterminer si le défilement est en pause ou non (0 pour non, 1 pour oui)
  var start;
  var timePause = 0;
  var timeoutVal;
  var pass = 0;
  var lastImgShow;

  spendSlide();                   // Appelle de la méthode spendSlide qui va activer le défilement



  function spendSlide()
  {
    start = new Date().getTime();
    timeoutVal = Math.floor(speed/100);

    currentPosition = 0;                        // La position par défaut est 0
    numberOfImg = $('.c_FigSlide').length;      // Nombre d'images à afficher
    speed = 7000;                               // Initialisation de la vitesse de défilement
    $('#Id_Container').css("width", (numberOfImg * 100 ) + "%");  // Initialise la taille du container en fonction du nombre d'images
    $('.c_FigSlide').css("width", (100 / numberOfImg) + "%");     // Initialise la taille de l'image en fonction du nombre d'images
    $('#Id_Pause').show();
    manageNav(currentPosition);

    lastImgShow = $('#Id_Slide0 div');
    lastImgShow.show();
    slideWidth = $("#Id_SlideWindow").width(); // Largeur de l'image en px 
    animateUpdate();
 //   slideShowInterval = setInterval(changePosition, speed);         // Pour un intervale de temps déterminé par speed, la méthode changePosition est appelée

    function animateUpdate() 
    {
      if(pass == 0) // Si l'utilisateur n'a pas changé l'image manuellement via les boutons Left ou Right
      {
        var now = new Date().getTime();
        var timeDiff = now - start;                   // Différence entre le temps au lancement de l'image et le temps courant
        var perc = Math.round((timeDiff/speed)*100);  // Détermine un pourcentage en fonction de la différence précédement calculée
        if (perc <= 100)                              // Si la barre de progression n'est pas encore arrivée à 100%
        {
          updateProgress(perc);                       // Mise à jour visuellement de l'avancement de la barre de progression
          if(pause == 0)                              // Si l'utilisateur n'a pas appuyé sur le bouton pause, on relance la fonction pour faire avancer la barre de progression
          {
            setTimeout(animateUpdate, timeoutVal);
          }
          else                                        // Sinon on mémorise le temps au moment de la pause
          {
            timePause = now;
          }
        }
        else                                          // Sinon
        {
          changePosition();                           // On change l'image a affichée dans le slide
          start = new Date().getTime();               // On réinitialise le temps de départ
          setTimeout(animateUpdate, timeoutVal);      // On relance la fonction de gestion de la barre de progression
        }
      }
      else  // Sinon 
      {
        updateProgress(0);                            // Réinitialisation de l'avancement de la barre de progression
        pass = 0;
        if(pause == 0)                                // Si l'utilisateur n'a pas appuyé sur le bouton pause
        {
          start = new Date().getTime();               // On réinitialise le temps de départ
          setTimeout(animateUpdate, timeoutVal);      // On relance la fonction de gestion de la barre de progression
        }
      }    
    }


    function updateProgress(percentage) {
      $('#texteJQ').html(percentage);
      $('#Id_ProgressBar').css("width", percentage + "%");
    }

    $('#Id_Pause').click(function() {              //met en pause le slide
      clearInterval(slideShowInterval);
      pause = 1;
      $('#Id_Pause').hide();
      $('#Id_Play').show();
    });

    $('#Id_Play').click(function() {               //relance le slide
  //    clearInterval(slideShowInterval);
   //   slideShowInterval = setInterval(changePosition, speed);
      pause = 0;                                    // Indication que la pause est levée
      if(timePause != 0)
      {
        var timeDiff = timePause - start;
        var tempDate = new Date().getTime();
        start = tempDate - timeDiff;
      }
      else
      {
        start = new Date().getTime();
      }
      setTimeout(animateUpdate, timeoutVal); // La barre de progression est relancée
      $('#Id_Play').hide();
      $('#Id_Pause').show();
    });

    $('.C_NavSlide').click(function() 
    {                //lorque l'on clique sur la flèche gauche
    //  clearInterval(slideShowInterval);
      currentPosition = ($(this).attr('id') == 'Id_Right') ? currentPosition + 1 : currentPosition - 1;
      manageNav(currentPosition);
      moveSlide();
      pass = 1;
      if(pause == 1) 
      {     //si le bouton pause est "on" on ne relance pas l'interval
       // slideShowInterval = setInterval(changePosition, speed);
      //  animateUpdate();
       updateProgress(0);
      }
    });

    $('.C_ChoiceSlide').click(function() 
    {   
    //   clearInterval(slideShowInterval);
      var cls = $(this).attr('id');

   /*   $('#texteJQ2').html('#'+cls+ " div");
      

      $('#' + cls + " div").show();*/

      var lastCharConvertToInt = parseInt(cls.substr(cls.length - 1)); // => "1"

      if(lastCharConvertToInt != null)
      {
        $('#texteJQ').html(lastCharConvertToInt);
        if (currentPosition != lastCharConvertToInt)
        {
          currentPosition = lastCharConvertToInt;
          manageNav(currentPosition);
        /*  if(pause == 0)   // Si le bouton pause n'est pas activé on relance l'interval
          {   
         //   slideShowInterval = setInterval(changePosition, speed);
          }
          moveSlide();*/

          moveSlide();
          pass = 1;
          if(pause == 1) 
          {     //si le bouton pause est "on" on ne relance pas l'interval
           // slideShowInterval = setInterval(changePosition, speed);
          //  animateUpdate();
           updateProgress(0);
          }
        }
      }
    });

    //affiche ou cache la flèche de navigation
    function manageNav(position) 
    {               
      if (position == 0) 
      {
        $('#Id_Left').hide();
      }
      else 
      {
        $('#Id_Left').show();
      }
      if (position == numberOfImg - 1) 
      {
        $('#Id_Right').hide();
      }
      else 
      {
        $('#Id_Right').show();
      }
    }


    function changePosition() 
    {
      if (currentPosition == (numberOfImg-1))
      {
        currentPosition = 0;
      } 
      else 
      {
        currentPosition++;
      }
      moveSlide();                              // Appelle de la méthode pour changer d'image
    }


    function moveSlide() 
    {
      $('.c_FigSlide figcaption').animate({'height': 0});
      $('#Id_Container').animate({'marginLeft': (100  * (-currentPosition))+'%'});
      $('.c_FigSlide figcaption').animate({'height': 75});
      lastImgShow.hide();
      lastImgShow = $('#Id_Slide'+currentPosition+' div');
      lastImgShow.show();
      manageNav(currentPosition);
    }

    // Si la fenêtre est redimenssioné
    $(window).resize(function(){
      slideWidth = $("#Id_SlideWindow").width(); // Largeur de l'image en px 
      $('#texteJQ2').html(slideWidth);
      $('#Id_Container').css({'marginLeft': (100  * (-currentPosition))+'%'});
    }) 
  }
 /* $('#texteJQ').html('Hello world. Ce texte est affiché par jQuery.');
  $('[Border=4]').css('border-color', 'blue');
  $(':input').css('background', 'yellow');
  $(':password').css('background','red');
   $(':image').css('width','100px');
   $(':image').css('height','100px');
   document.forms[0].nom.focus(); 
   $(':focus').css('background','blue');
   	
   var test = $('input').attr('type');
   document.write(test);*/

});