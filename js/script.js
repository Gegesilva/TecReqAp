$(window).on('load',function() { // Garante que todo o site seja carregado
    $('#status').fadeOut('fast'); // primeiro desaparecerá a animação de carregamento
    $('#preloader').delay(35).fadeOut('fast'); // desaparecerá o DIV branco que cobre o site.
    $('body').delay(350).css({'overflow':'visible'});

    console.log('teste loding')
  })