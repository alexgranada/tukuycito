(function ($) {
  "use strict";
  //------------------------------------------------------------------------------------------------------------------
  // preloder-heare
  //------------------------------------------------------------------------------------------------------------------

  var loader = document.getElementById("preloader");
  window.addEventListener("load", function () {
    loader.style.display = "none";
  });


  //------------------------------------------------------------------------------------------------------------------
  // left-menu-sidebar
  //------------------------------------------------------------------------------------------------------------------
  
  $(document).on("click", ".sidebar li", function () {
    $(this).addClass("active").siblings().removeClass("active");
  });
  $(document).on("click", ".single-sidebar li", function () {
    $(this).addClass("active").siblings().removeClass("active");
  });

  /*toogle-up-down*/
  $(".profile-dropdown").on("click", function () {
    $(".profile-active ").slideToggle({ direction: "up" }, 900);
  });
  //------------------------------------------------------------------------------------------------------------------
  // Off Canvas Menu
  //------------------------------------------------------------------------------------------------------------------

  var $offcanvasNav = $(".offcanvas_main_menu"),
    $offcanvasNavSubMenu = $offcanvasNav.find(".sub-menu");
  $offcanvasNavSubMenu
    .parent()
    .prepend(
      '<span class="menu-expand"><i class="fa fa-angle-down"></i></span>'
    );

  $offcanvasNavSubMenu.slideUp();

  $offcanvasNav.on("click", "li a, li .menu-expand", function (e) {
    var $this = $(this);
    if (
      $this
        .parent()
        .attr("class")
        .match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/) &&
      ($this.attr("href") === "#" || $this.hasClass("menu-expand"))
    ) {
      e.preventDefault();
      if ($this.siblings("ul:visible").length) {
        $this.siblings("ul").slideUp("slow");
      } else {
        $this.closest("li").siblings("li").find("ul:visible").slideUp("slow");
        $this.siblings("ul").slideDown("slow");
      }
    }
    if (
      $this.is("a") ||
      $this.is("span") ||
      $this.attr("clas").match(/\b(menu-expand)\b/)
    ) {
      $this.parent().toggleClass("menu-open");
    } else if (
      $this.is("li") &&
      $this.attr("class").match(/\b('menu-item-has-children')\b/)
    ) {
      $this.toggleClass("menu-open");
    }
  });

  //------------------------------------------------------------------------------------------------------------------
  // sidebar-toggle
  //------------------------------------------------------------------------------------------------------------------

  $(document).ready(function () {
    $(".toggle-menu").click(function () {
      $(".left-menu").toggleClass("hide");
      $(".content-wraper").toggleClass("hide");
    });
  });

  //------------------------------------------------------------------------------------------------------------------
  // Counter
  //------------------------------------------------------------------------------------------------------------------

  var $CounterUp = $('.counter');
  if($CounterUp.length > 0){
      $('.counter').counterUp({
          delay: 10,
          time: 2000
      });
  }

  $('.cm-cart-minus').on('click', function () {
    var $input = $(this).parent().find('input');
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
  });

  $('.cm-cart-plus').on('click', function () {
    var $input = $(this).parent().find('input');
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
  });

  // WOW JS
  new WOW().init();

})(jQuery);
