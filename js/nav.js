$(document).ready(function() {
  //const bodyScrollLock = require('body-scroll-lock');
  const disableBodyScroll = bodyScrollLock.disableBodyScroll;
  const enableBodyScroll = bodyScrollLock.enableBodyScroll;

  const hamburger = $('.hamburger');
  const nav = $('.nav');
  //const links = nav.find('li a');

  hamburger.on('click', function(e) {
    e.preventDefault();
    if (hamburger.attr('aria-expanded') == 'true') {
      toggleMenu(0);
    } else {
      toggleMenu(1);
    }
  })

  // links.on('click', function() {
  //   toggleMenu(0);
  // })

  function toggleMenu(open) {
    $('body').toggleClass('nav-open');
    if (open) {
      hamburger.attr('aria-expanded', true);
      nav.fadeIn(400);
      disableBodyScroll($('.nav-scroller'));
    } else {
      hamburger.attr('aria-expanded', false);
      nav.fadeOut(300);
      enableBodyScroll($('.nav-scroller'));
    }
  }
});