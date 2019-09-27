function collapse() {
  var x = document.getElementById("navbar");
  if (x.className === "navbar bg-dark fixed-top d-flex") {
    x.className += " responsive";
  } else {
    x.className = "navbar bg-dark fixed-top d-flex";
  }
}
function collapseSlide() {
  if ( $( "#responsiveNavbar" ).first().is( ":hidden" ) ) {
    $( "#responsiveNavbar" ).slideDown( "slow" );
  } else {
    $( "#responsiveNavbar" ).hide();
  }
}