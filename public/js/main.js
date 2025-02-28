// This is the non minified workable version of main.min.js, make sure to always update this before minfying

$.noConflict();
jQuery( document ).ready(function( $ ) {
  // fadeout alert message
  setTimeout(function() {

      $(".alert").not('.alert-reset-password, .alert-info, .alert-errors').fadeOut().remove();
    
  }, 5000); 

  $(window).scroll(function(){ 
      if ($(this).scrollTop() > 100) { 
          $('#scroll').fadeIn(); 
      } else { 
          $('#scroll').fadeOut(); 
      } 
  }); 
  
  $('.dashboard-tab-content').on('scroll', function() { 
      if ($(this).scrollTop() > 100) {  
          $('#dashScroll').fadeIn(); 
      } else { 
          $('#dashScroll').fadeOut(); 
      } 
  });
  $('#scroll').click(function(){ 
      $("html, body").animate({ scrollTop: 0 }, 600); 
      return false; 
  }); 
  $('#dashScroll').click(function(){ 
      $(".dashboard-tab-content").animate({ scrollTop: 0 }, 600); 
      return false; 
  }); 

  // Featured Nanny Slider
  $('.featured-nanny-slider').slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    prevArrow: "<i class='fas fa-chevron-left slick-arrow' aria-hidden='true'></i>",
    nextArrow: "<i class='fas fa-chevron-right' aria-hidden='true'></i>",
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 550,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });
  // Testimonial Slider
  $('.testimonial-slider, .awards-slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 1400,
    prevArrow: "<i class='fas fa-chevron-left slick-arrow' aria-hidden='true'></i>",
    nextArrow: "<i class='fas fa-chevron-right' aria-hidden='true'></i>",
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 550,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });
  // Revenue Slider
  $('.revenue-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    cssEase: 'linear',
    prevArrow: $('.prev-year'),
    nextArrow: $('.next-year'),
    swipe: false,
    initialSlide: $('.revenue-slider .slick-slide').length - 1
  });

  //Agenda Slider
  $('.agenda-slider').slick({
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1
  });
  //Refresh Slick Slider with Accordion Issue
  $('#agenda-accordion').on('show.bs.collapse', function (e) {
    $('.agenda-slider').slick('refresh');
  });

  //Agenda Pagination
  $('.agenda-slider').each(function() {
    var $status = $(this).find('.page-number');
    $(this).on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      if(!slick.$dots){
        return;
      }
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.text(i + '/' + (slick.$dots[0].children.length));
    });
  });
  
  // Show Password
  $('.show-password').click(function() {
    if ($('#password-box').attr('type') == 'text') {
      $('#password-box').attr('type', 'password');
      $('.show-password').text('Show password');
    } else {
      $('#password-box').attr('type', 'text');
      $('.show-password').text('Hide password');
    }
  });

  // Show Password for reg form
  $('.show-password-reg').click(function() {
    if ($('.password-box-reg').attr('type') == 'text') {
      $('.password-box-reg').attr('type', 'password');
      $('.show-password-reg').text('Show password');
    } else {
      $('.password-box-reg').attr('type', 'text');
      $('.show-password-reg').text('Hide password');
    }
  });
  
  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  $(".toggle-password-confirmation").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  // Log in and Sign up Modal
  $('.signUp').click(function(e){
    e.preventDefault();
    $('#log-in-modal, #user-modal, #mentor-modal')
      .modal('hide')
      .on('hidden.bs.modal', function (e) {
        $('#sign-up-modal').modal('show');
        $(this).off('hidden.bs.modal'); // Remove the 'on' event binding
    });
  });

  $('.logIn').click(function(e){
    e.preventDefault();
    $('#user-modal, #mentor-modal')
      .modal('hide')
      .on('hidden.bs.modal', function (e) {
        $('#log-in-modal').modal('show');
        $(this).off('hidden.bs.modal'); // Remove the 'on' event binding
    });
  });

  $('.sign-up-radio input[name="role"]').change(function() {
    if($('input#customRadioNanny').is(":checked")) {
      $('.sign-up-bdate').removeClass('hide');
    } else if ($('input#customRadioParent').is(":checked")) {
      $('.sign-up-bdate').addClass('hide');
    }
  });  

  if($('input#customRadioNanny').is(":checked")) {
    $('.sign-up-bdate').removeClass('hide');
  } else if ($('input#customRadioParent').is(":checked")) {
    $('.sign-up-bdate').addClass('hide');
  }

  // mentors add job description
  $('#add-jd-btn').click(function() {
    $('.add-jd-wrap:last').clone().find("input:text").val("").end().appendTo('.job-description-wrap');    
    $('.add-jd-wrap').each(function() {
      if (!$(this).children('.del-jd-btn').length) {
        $(this).append('<button type="button" class="brown del-jd-btn new-profile-form"><i class="fas fa-trash"></i></button>');
      }      
    });
  });

  $('.add-jd-wrap').each(function() {
    if ($('.add-jd-wrap').length > 1) {
      if (!$(this).children('.del-jd-btn').length) {
        $(this).append('<button type="button" class="brown del-jd-btn new-profile-form hide"><i class="fas fa-trash"></i></button>');
      }   
    }
  });
 
  $('.job-description-wrap').on('click','.del-jd-btn', function(){
    if ($('.add-jd-wrap').length == 2) {
      $(this).parent('.add-jd-wrap').remove();
      $('.del-jd-btn').remove();
       
    } else if ($('.add-jd-wrap').length > 2) {
      $(this).parent('.add-jd-wrap').remove();
    }
  });

  // mentors add training
  $('#add-trn-btn').click(function() {
    $('.add-trn-wrap:last').clone().find("input:text").val("").end().appendTo('.training-wrap');    
    $('.add-trn-wrap').each(function() {
      if (!$(this).children('.del-trn-btn').length) {
        $(this).append('<button type="button" class="brown del-trn-btn new-profile-form"><i class="fas fa-trash"></i></button>');
      }      
    });
  });

  $('.add-trn-wrap').each(function() {
    if ($('.add-trn-wrap').length > 1) {
      if (!$(this).children('.del-trn-btn').length) {
        $(this).append('<button type="button" class="brown del-trn-btn new-profile-form hide"><i class="fas fa-trash"></i></button>');
      }   
    }
  });
 
  $('.training-wrap').on('click','.del-trn-btn', function(){
    if ($('.add-trn-wrap').length == 2) {
      $(this).parent('.add-trn-wrap').remove();
      $('.del-trn-btn').remove();
       
    } else if ($('.add-trn-wrap').length > 2) {
      $(this).parent('.add-trn-wrap').remove();
    }
  });

  // mentors add event details
  $('.add-evt-dtl-btn').click(function() {
    $('.blank-event-dtls .event-details').clone().appendTo('.event-details-wrap');  

    renameFields();

    var evtDtlsCount = $('.event-details-wrap .js-evt-count').length;
    $('input[name="event-details-count"]').val(evtDtlsCount);

  });

  var evtDtlsCount = $('.event-details-wrap .js-evt-count').length;
  $('input[name="event-details-count"]').val(evtDtlsCount);

  $('.event-details-wrap').on('click','.del-evt-dtls-btn', function(){
    $(this).parent('.event-details').remove();

    renameFields();

    var evtDtlsCount = $('.event-details-wrap .js-evt-count').length;
    $('input[name="event-details-count"]').val(evtDtlsCount);

  });

  function renameFields() {
    $('.event-details').each(function(index) {
      $(this).addClass('test');
      $(this).find('.sd-day').attr('name','sd-day['+(index)+'][]');
      $(this).find('.sd-month').attr('name','sd-month['+(index)+'][]');
      $(this).find('.sd-year').attr('name','sd-year['+(index)+'][]');
      $(this).find('.start-hr').attr('name','st-start-hr['+(index)+']');
      $(this).find('.start-min').attr('name','st-start-min['+(index)+']');
      $(this).find('.end-hr').attr('name','st-end-hr['+(index)+']');
      $(this).find('.end-min').attr('name','st-end-min['+(index)+']');
      $(this).find('.lang-select').attr('name','language['+(index)+']');
      $(this).find('.lang-other').attr('name','other-lang['+(index)+']');
      $(this).find('.venue-input').attr('name','venue['+(index)+']');
      $(this).find('.fee-input').attr('name','fee['+(index)+']');
      $(this).find('.promo-input').attr('name','promo['+(index)+']');
    });
  }

  // mentors add session date
  $('.event-details-wrap').on('click','.add-date-btn', function(){
    $(this).prev('.session-date').find('.session-date-inner:last').clone().appendTo($(this).prev('.session-date'));
  });
 
  $('.event-details-wrap').on('click','.del-sd-btn', function(){
    $(this).parent('.session-date-inner').remove();
  });

  // agenda session time
  $('.event-details-wrap').on('click','.hr-up',function() {
    var hour = $(this).next('.hr').val();
    hour++;
    if (hour > 23) {
      hour = 0;
    }
    $(this).next('.hr').val(formatTime(hour));
  });

  $('.event-details-wrap').on('click','.hr-down',function() {
    var hour = $(this).prev('.hr').val();
    hour--;
    if (hour < 0) {
      hour = 23;
    }
    $(this).prev('.hr').val(formatTime(hour));
  });

  $('.event-details-wrap').on('click','.min-up',function() {
    var minute = $(this).next('.min').val();
    minute++;
    if (minute > 59) {
      minute = 0;
    }
    $(this).next('.min').val(formatTime(minute));
  });

  $('.event-details-wrap').on('click','.min-down',function() {
    var minute = $(this).prev('.min').val();
    minute--;
    if (minute < 0) {
      minute = 59;
    }
    $(this).prev('.min').val(formatTime(minute));
  });

  $('.event-details-wrap').on('change','.hr',function() {
    if ($(this).val() > 23 || $(this).val() < 0 || $(this).val() == "") {
      $(this).val(formatTime(0));
    } 
  });

  $('.event-details-wrap').on('change','.min',function() {
    if ($(this).val() > 59 || $(this).val() < 0 || $(this).val() == "") {
      $(this).val(formatTime(0));
    } 
  });

  function formatTime (time) {
    if (time < 10) {
      time = '0' + time;
    }
    return time;
  }

    // unauthorized modal
  jQuery('#unauthorizedModal').modal('show');

  // view usr modal Home Page
  $('#user-modal, #mentor-modal').on('show.bs.modal', function(e) {

    if ($(this).attr('id') == 'user-modal') {
      var gender = $(e.relatedTarget).data('gender');
      var exp = $(e.relatedTarget).data('exp');
      var age = $(e.relatedTarget).data('age');
      var stages = $(e.relatedTarget).data('stages');
      var activities = $(e.relatedTarget).data('activities');
      var services = $(e.relatedTarget).data('services');
      var dawn = $(e.relatedTarget).data('dawn');
      var morning = $(e.relatedTarget).data('morning');
      var afternoon = $(e.relatedTarget).data('afternoon');
      var evening = $(e.relatedTarget).data('evening');
      var mon = $(e.relatedTarget).data('mon');
      var tue = $(e.relatedTarget).data('tue');
      var wed = $(e.relatedTarget).data('wed');
      var thu = $(e.relatedTarget).data('thu');    
      var fri = $(e.relatedTarget).data('fri');
      var sat = $(e.relatedTarget).data('sat');
      var sun = $(e.relatedTarget).data('sun');

      $(e.currentTarget).find('.gender').html(gender);
      $(e.currentTarget).find('.exp').html(exp);
      $(e.currentTarget).find('.age').html(age);
      $(e.currentTarget).find('.stages').html(stages);
      $(e.currentTarget).find('.activities').html(activities);
      $(e.currentTarget).find('.services').html(services);
      $(e.currentTarget).find('tr.dawn').html(dawn);
      $(e.currentTarget).find('tr.morning').html(morning);
      $(e.currentTarget).find('tr.afternoon').html(afternoon);
      $(e.currentTarget).find('tr.evening').html(evening);
      $(e.currentTarget).find('tr.mon').html(mon);
      $(e.currentTarget).find('tr.tue').html(tue);
      $(e.currentTarget).find('tr.wed').html(wed);
      $(e.currentTarget).find('tr.thu').html(thu); 
      $(e.currentTarget).find('tr.fri').html(fri);
      $(e.currentTarget).find('tr.sat').html(sat);
      $(e.currentTarget).find('tr.sun').html(sun);
    } 

    if ($(this).attr('id') == 'mentor-modal') {
      var trainings = $(e.relatedTarget).data('trainings');
      $(e.currentTarget).find('.trainings').html(trainings);
    }

    var id = $(e.relatedTarget).data('id');
    var pic = $(e.relatedTarget).data('pic');
    var fname = $(e.relatedTarget).data('fname');
    var city = $(e.relatedTarget).data('city');
    var job = $(e.relatedTarget).data('job');
    var desc = $(e.relatedTarget).data('desc');
    var status = $(e.relatedTarget).data('status');
    var link = $(e.relatedTarget).data('link');
    
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.pic').css('background-image', 'url(' + pic + ')');
    $(e.currentTarget).find('.fname').html(fname);
    $(e.currentTarget).find('.city').html(city);
    $(e.currentTarget).find('.job').html(job);
    $(e.currentTarget).find('.desc').html(desc);
    $(e.currentTarget).find('.desc-form').val(desc);
    $(e.currentTarget).find('span.status').replaceWith(status);
    $(e.currentTarget).find('a.viewProfile').attr('href',link);

    // Set a cookie
    document.cookie = "profile="+link;

    $('.profile-modalWlist').each(function() {
      var firstLi = $(this).find('.list-divider li:first-child').text();
      if(firstLi == ""){
        $(this).addClass('hide');
      }
    });
  });

   // subscription modal Home Page
  $('#userSubsModalIdeal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var plan = $(e.relatedTarget).data('plan');
    var paymentMode = $(e.relatedTarget).data('payment-mode');
    var subsEnd = $(e.relatedTarget).data('subs-end');
    $(e.currentTarget).find('.plan').html(plan);
    $(e.currentTarget).find('.payment-mode').html(paymentMode);
    $(e.currentTarget).find('.subs-end').html(subsEnd);
  });

   $('#userSubsModalCard').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var plan = $(e.relatedTarget).data('plan');
    var paymentMode = $(e.relatedTarget).data('payment-mode');
    var cardBrand = $(e.relatedTarget).data('card-brand');
    var cardLastFour = $(e.relatedTarget).data('card-last-four');
    $(e.currentTarget).find('.plan').html(plan);
    $(e.currentTarget).find('.payment-mode').html(paymentMode);
    $(e.currentTarget).find('.card-brand').html(cardBrand);
    $(e.currentTarget).find('.card-last-four').html(cardLastFour);
  });

  $('#log-in, #sign-up, #sign-up-footer').click(function() {
    document.cookie = "profile=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  });

  $('#admin-user-modal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var pic = $(e.relatedTarget).data('pic');
    var gender = $(e.relatedTarget).data('gender');
    var exp = $(e.relatedTarget).data('exp');
    var fname = $(e.relatedTarget).data('fname');
    var city = $(e.relatedTarget).data('city');
    var age = $(e.relatedTarget).data('age');
    var job = $(e.relatedTarget).data('job');
    var stages = $(e.relatedTarget).data('stages');
    var activities = $(e.relatedTarget).data('activities');
    var services = $(e.relatedTarget).data('services');
    var desc = $(e.relatedTarget).data('desc');
    var status = $(e.relatedTarget).data('status');

    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.pic').css('background-image', 'url(' + pic + ')');
    $(e.currentTarget).find('.gender').html(gender);
    $(e.currentTarget).find('.exp').html(exp);
    $(e.currentTarget).find('.fname').html(fname);
    $(e.currentTarget).find('.city').html(city);
    $(e.currentTarget).find('.age').html(age);
    $(e.currentTarget).find('.job').html(job);
    $(e.currentTarget).find('.stages').html(stages);
    $(e.currentTarget).find('.activities').html(activities);
    $(e.currentTarget).find('.services').html(services);
    $(e.currentTarget).find('.desc').html(desc);
    $(e.currentTarget).find('.desc-form').val(desc);
    $(e.currentTarget).find('span.status').replaceWith(status);
  });

  // delete user modal
  $('#deleteUserModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.user-name').html(name);
  });

  // suspend user modal
  $('#suspendUserModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.user-name').html(name);
  });

  // block user modal
  $('#blockUserModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.user-name').html(name);
  });  

  // activate user modal
  $('#activateUserModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.user-name').html(name);
  });

  // delete faq modal
  $('#deleteModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var question = $(e.relatedTarget).data('question');
    var answer = $(e.relatedTarget).data('answer');
    $(e.currentTarget).find('input[name="faqId"]').val(id);
    $(e.currentTarget).find('textarea[name="answer"]').val(answer);
    $(e.currentTarget).find('span.faq-title').html(question);
  });

  // delete blog modal
  $('#deleteBlogModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var title = $(e.relatedTarget).data('post-title');
    $(e.currentTarget).find('input[name="postId"]').val(id);
    $(e.currentTarget).find('.post-title').html(title);
  });

  // delete agenda modal
  $('#deleteAgendaModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var title = $(e.relatedTarget).data('agenda-title');
    $(e.currentTarget).find('input[name="agendaId"]').val(id);
    $(e.currentTarget).find('.agenda-title').html(title);
  });

    // delete Cookie item modal
  $('#deleteCookieModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var title = $(e.relatedTarget).data('title');
    $(e.currentTarget).find('input[name="cookieId"]').val(id);
    $(e.currentTarget).find('.title').html(title);
  });

  // edit testimonial modal
  $('#editTestiModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var author = $(e.relatedTarget).data('author');
    var content = $(e.relatedTarget).data('content');
    var rating = $(e.relatedTarget).data('rating');
    var hidden = $(e.relatedTarget).data('hidden');

    if (hidden == 1) {
      $(e.currentTarget).find('input[name="hidden"]').attr('checked','checked');
    }

    $(e.currentTarget).find('input[name="testiId"]').val(id);
    $(e.currentTarget).find('textarea[name="content"]').val(content);
    $(e.currentTarget).find('input[name="author"]').val(author);
    $(e.currentTarget).find('#'+rating).attr('selected','selected');
  });

  // delete testimonial modal
  $('#deleteTestiModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var author = $(e.relatedTarget).data('author');
    $(e.currentTarget).find('input[name="testiId"]').val(id);
    $(e.currentTarget).find('.author').html(author);
  });

  // edit category modal
  $('#updCatModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var category = $(e.relatedTarget).data('category');

    $(e.currentTarget).find('input[name="catId"]').val(id);
    $(e.currentTarget).find('input[name="category"]').val(category);
     $(e.currentTarget).find('.category').html(category);
  });

   // delete category item modal
  $('#delCatModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var category = $(e.relatedTarget).data('category');
    $(e.currentTarget).find('input[name="catId"]').val(id);
    $(e.currentTarget).find('.category').html(category);
  });

  // delete member modal
  $('#deleteMemberModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="memberId"]').val(id);
    $(e.currentTarget).find('.name').html(name);
  });

  // edit awards modal
  $('#editAwardModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var title = $(e.relatedTarget).data('title');
    var image = $(e.relatedTarget).data('image');

    $(e.currentTarget).find('input[name="awardId"]').val(id);
    $(e.currentTarget).find('input[name="title"]').val(title);
    $(e.currentTarget).find('input[name="oldImage"]').val(image);
    $(e.currentTarget).find('#image').attr('src',image).attr('alt',title);
  });

   // delete awards modal
  $('#deleteAwardModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var title = $(e.relatedTarget).data('title');
    $(e.currentTarget).find('input[name="awardId"]').val(id);
    $(e.currentTarget).find('.title').html(title);
  });

  // remarks modal
  $('#remarksModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var remarks = $(e.relatedTarget).data('remarks');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('textarea[name="remarks"]').val(remarks);
  });

  // process vetting modal
  $('#processVetModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.user-name').html(name);
  });

  // pend vetting modal
  $('#pendVetModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.user-name').html(name);
  });

  // pass vetting modal
  $('#passVetModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.user-name').html(name);
  });

  // fail vetting modal
  $('#failVetModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="userId"]').val(id);
    $(e.currentTarget).find('.user-name').html(name);
  });

  // toggle switches on account settings
  $("#vettingForm").on("change", "input:checkbox", function(){
      $("#vettingForm").submit();
  });

  $("#cookieForm").on("change", "input:checkbox", function(){
      $("#cookieForm").submit();
  });

  // cancel subscription modal
  $('#cancelSubsModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    $(e.currentTarget).find('input[name="userId"]').val(id);
  });

  // Profile items on search
  $(window).on("resize", function () {
    $('.js-profile-pic').each(function(){
        var height = $(this).width();
        $(this).height(height);
    });

    if(window.innerWidth > 991){ //3 cols align cta
      var maxHeight1strow = 0;
      var maxHeight2ndrow = 0;
      $(".search-details, .blog-item-inner").css('height','auto');

      $(".search-details, .blog-item-inner").each(function(index){
        if ($(this).height() > maxHeight1strow && index <= 2) { 
          maxHeight1strow = $(this).height();             
        } else if ($(this).height() > maxHeight2ndrow && index >= 3) {
          maxHeight2ndrow = $(this).height();
        }
      });

      $(".search-result-item:nth-of-type(1) .search-details, .blog-item:nth-of-type(1) .blog-item-inner").height(maxHeight1strow);
      $(".search-result-item:nth-of-type(2) .search-details, .blog-item:nth-of-type(2) .blog-item-inner").height(maxHeight1strow);
      $(".search-result-item:nth-of-type(3) .search-details, .blog-item:nth-of-type(3) .blog-item-inner").height(maxHeight1strow);
      $(".search-result-item:nth-of-type(4) .search-details, .blog-item:nth-of-type(4) .blog-item-inner").height(maxHeight2ndrow);
      $(".search-result-item:nth-of-type(5) .search-details, .blog-item:nth-of-type(5) .blog-item-inner").height(maxHeight2ndrow);
      $(".search-result-item:nth-of-type(6) .search-details, .blog-item:nth-of-type(6) .blog-item-inner").height(maxHeight2ndrow);
      
    } else if (window.innerWidth > 575 && window.innerWidth < 992) { //2 cols align cta
      var maxHeight1strow = 0;
      var maxHeight2ndrow = 0;
      var maxHeight3rdrow = 0;
      $(".search-details, .blog-item-inner").css('height','auto');

      $(".search-details, .blog-item-inner").each(function(index){
        if ($(this).height() > maxHeight1strow && index <= 1) { 
          maxHeight1strow = $(this).height();             
        } else if ($(this).height() > maxHeight3rdrow && index >= 5) {
          maxHeight3rdrow = $(this).height();
        } else {
          if ($(this).height() > maxHeight2ndrow) {
            maxHeight2ndrow = $(this).height();
          }
        }
      });

      $(".search-result-item:nth-of-type(1) .search-details, .blog-item:nth-of-type(1) .blog-item-inner").height(maxHeight1strow);
      $(".search-result-item:nth-of-type(2) .search-details, .blog-item:nth-of-type(2) .blog-item-inner").height(maxHeight1strow);
      $(".search-result-item:nth-of-type(3) .search-details, .blog-item:nth-of-type(3) .blog-item-inner").height(maxHeight2ndrow);
      $(".search-result-item:nth-of-type(4) .search-details, .blog-item:nth-of-type(4) .blog-item-inner").height(maxHeight2ndrow);
      $(".search-result-item:nth-of-type(5) .search-details, .blog-item:nth-of-type(5) .blog-item-inner").height(maxHeight3rdrow);
      $(".search-result-item:nth-of-type(6) .search-details, .blog-item:nth-of-type(6) .blog-item-inner").height(maxHeight3rdrow);

    } else {
      $(".search-details, .blog-item-inner").css('height','auto');
    }

    $('.author-img').each(function(){
        var height = $(this).width();
        $(this).height(height);
    });

    // dashboard-tab-content dynamic height
    
    var windowH = $(window).height();
    var headerH = $('.header-wrapper').height();
    var innerHDash = $('.dashboard-tab-content').height();
    var outerHDash = $('.dashboard-tab-content').outerHeight();
    var padTB = outerHDash - innerHDash;

    if (window.innerWidth > 767){
      var dashH = windowH - (headerH + padTB);
    } else {
      var dashH = windowH - (headerH + 120);
    }    

    $('.dashboard-tab-content').css('height',dashH);
    

    // message feed adjusting to .dashboard-tab-content parent
    var chatParentHeight = $('.dashboard-tab-content').outerHeight();
    var chatInfoHeight = $('.msg-info').outerHeight();
    var chatSenderHeight = $('.msg-sender').outerHeight();

    if (window.innerWidth > 420){
      $('.feed').height( chatParentHeight - chatInfoHeight - chatSenderHeight - 66);
    } else {
      $('.feed').height( chatParentHeight - chatInfoHeight - chatSenderHeight - 36);  
    }

    // BLOG FEATURED IMAGE HEIGHT
    var blogInnerHeader = $('.blog-inner-header').height();
    var blogInnerForm = $('.blog-inner-subsform form').outerHeight();
    var blogInnerFimage = blogInnerForm - blogInnerHeader;

    var blogFimageW = $('.blog-inner-Fimage').width();

    if ($(window).width() < 420) {
      $('.blog-inner-Fimage').css('height', blogFimageW);
    } else if ($(window).width() > 420 && $(window).width() < 900) {
      $('.blog-inner-Fimage').css('height', '450px');
    } else {
      $('.blog-inner-Fimage').css('height', blogInnerFimage);
    }
    
    // subsform on blog post
    if ($(window).width() < 768) {
      $('.blog-subsform-desktop').hide();
      $('.blog-subsform-mobile').show();
      $('.gdpr-mergeRow').detach().prependTo('.gdpr-wrap-mob');
    } else {
      $('.blog-subsform-mobile').hide();
      $('.blog-subsform-desktop').show();
      $('.gdpr-mergeRow').detach().prependTo('.gdpr-wrap-desk');
    }

  }).resize();

  // Search box update location on change
  $("input#search").change(function(){
    var searchLoc = $(this).val();
    $('input[name="search-location"]').val(searchLoc);
  });

  // search via radio button
  $('.search-job-desc input[type=radio][name=job-desc]').on('change', function() {
    $('#searchJobDesc').submit();
  });

  // Advanced Search
  $('.advance-search').on('click', function(){
    $('.search-filter-container').addClass('right-left');
    $('html, body').addClass('overflow-x');
    $('.full-WH').addClass('bg-filter right-left');
  });
  $('.full-WH, .search-filter-container .filter-header button.close').on('click', function(){
    $('.search-filter-container').removeClass('right-left');
    $('.full-WH').removeClass('bg-filter right-left');
  });

  // ADVACNED SEARCH 
  // HOURLY RATE
  $( "#Hourlyslider-range" ).slider({
    range: true,
    min: 5,
    max: 20,
    values: [ 5, 20 ],
    slide: function( event, ui ) {
      $( "#HourlyfirstVal" ).val(ui.values[ 0 ]);
      $( "#HourlysecondVal" ).val(ui.values[ 1 ]);
    }
  });
  $( "#HourlyfirstVal" ).val($( "#Hourlyslider-range" ).slider( "values", 0));
  $( "#HourlysecondVal" ).val($( "#Hourlyslider-range" ).slider( "values", 1));
  // AGE OF CHILDREN
  $( "#AgeChildslider-range" ).slider({
    range: true,
    min: 0,
    max: 16,
    values: [ 0, 16 ],
    slide: function( event, ui ) {
      $( "#AgeChildfirstVal" ).val(ui.values[ 0 ]);
      $( "#AgeChildsecondVal" ).val(ui.values[ 1 ]);
    }
  });
  $( "#AgeChildfirstVal" ).val($( "#AgeChildslider-range" ).slider( "values", 0 ) );
  $( "#AgeChildsecondVal" ).val($( "#AgeChildslider-range" ).slider( "values", 1 ) );
  // NUMBER OF CHILDREN
  $( "#NumChildslider-range" ).slider({
    range: true,
    min: 1,
    max: 5,
    values: [ 1, 5 ],
    slide: function( event, ui ) {
      $( "#NumChildfirstVal" ).val(ui.values[ 0 ]);
      $( "#NumChildsecondVal" ).val(ui.values[ 1 ]);
    }
  });
  $( "#NumChildfirstVal" ).val($( "#NumChildslider-range" ).slider( "values", 0 ) );
  $( "#NumChildsecondVal" ).val($( "#NumChildslider-range" ).slider( "values", 1 ) );
  // DISTANCE
  $( "#Distanceslider-range" ).slider({
    range: true,
    min: 0,
    max: 50,
    values: [ 0, 50 ],
    slide: function( event, ui ) {
      $( "#DistancefirstVal" ).val(ui.values[ 0 ]);
      $( "#DistancesecondVal" ).val(ui.values[ 1 ]);
    }
  });
  $( "#DistancefirstVal" ).val($( "#Distanceslider-range" ).slider( "values", 0 ));
  $( "#DistancesecondVal" ).val($( "#Distanceslider-range" ).slider( "values", 1 ));
  // ADVANCE SEARCH DESKTOP TO MOBILE MIRROR
  $( ".desktop-sched-cal input[type=checkbox]" ).on( "click", function() {
    var activebox = $(this).attr('name');
    if($(this).prop("checked") == true){
      $('.mobile-sched-cal input[name='+activebox+']').prop("checked",true);
    }
    if($(this).prop("checked") == false){
      $('.mobile-sched-cal input[name='+activebox+']').prop("checked",false);
    }
  });  
  // ADVANCE SEARCH MOBILE TO DESKTOP MIRROR
  $( ".mobile-sched-cal input[type=checkbox]" ).on( "click", function() {
    var activebox = $(this).attr('name');
    if($(this).prop("checked") == true){
      $('.desktop-sched-cal input[name='+activebox+']').prop("checked",true);
    }
    if($(this).prop("checked") == false){
      $('.desktop-sched-cal input[name='+activebox+']').prop("checked",false);
    }
  }); 
  // ACTIVE STATE OF NAVIGATION
  var pathname = location.pathname.split('/')[1];
  $('.navbar-nav > li > a[href="/'+pathname+'"]').addClass('active');

  // ACTIVE STATE OF DASHBOARD TAB
  $(".dashboard-tab .nav a").filter(function(){
    return this.href == location.href.replace(/#.*/, "");
  }).addClass("active");
  var pathnameSecond = location.pathname.split('/')[2];
  $('.dashboard-tab .nav a[href="'+pathnameSecond+'"]').addClass('active');
  if(pathnameSecond == 'pages'){
    $('.dashboard-tab .nav a[href="/admin/pages"]').addClass('active');
  }
  if(pathnameSecond == 'users'){
    $('.dashboard-tab .nav a[href="/admin/users"]').addClass('active');
  }

  // ACTIVE STATE OF BLOG FILTER
  $('.blog-filter ul li a[href="/blog/'+pathnameSecond+'"]').addClass('active');
  if (!pathnameSecond) {
    $('.blog-filter ul li a[href="/'+pathname+'"]').addClass('active');
  }  

  // SORTH TABLE
  $('.table.table-vetting th, .table.dashboard-table th').click(function(){
    var table = $(this).parents('table').eq(0);
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc
    if (!this.asc){
      rows = rows.reverse();
    }
    for (var i = 0; i < rows.length; i++){
      table.append(rows[i]);
    }
  });
  $('.table.table-user th').click(function(){
    var table = $(this).parents('table').eq(0);
    var rows = table.find('tr:gt(1)').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc
    if (!this.asc){
      rows = rows.reverse();
    }
    for (var i = 0; i < rows.length; i++){
      table.append(rows[i]);
    }
  });
  function comparer(index) {
    return function(a, b) {
      var valA = getCellValue(a, index), valB = getCellValue(b, index);
      return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
    }
  }
  function getCellValue(row, index){ 
    return $(row).children('td').eq(index).text();
  }

  // CHOOSE FILE
  $(".file-upload").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".fileName").html(fileName);
  });
  // USER MESSAGES
  $('.message-item').on('click', function(){
    $('.msg-container').removeClass('non-visible');
  });
  $('.back-btn .fa-arrow-left').on('click', function(){
    $('.msg-container').addClass('non-visible');
  });
  var messagearea = $('textarea.msg-input');
  messagearea.on('keydown', autosize);
  function autosize(){
    var el = this;
    setTimeout(function(){
      el.style.cssText = 'height:auto;';
      el.style.cssText = '-moz-box-sizing:content-box';
      el.style.cssText = 'height:' + el.scrollHeight + 'px';
    },0);
  }

  // Review Form
  $('#reviewForm').hide();
  $('.submit-review-btn').on('click', function(e){
    e.preventDefault();
    $('#reviewForm').show();
    $(this).hide();
  });

   // reshow Review Form if has error
  if ($('#reviewForm').find('.error').length) {
    $('#reviewForm').show();
    $('.submit-review-btn').hide();
    $('#reviewForm').get(0).scrollIntoView();
  }

  // reshow Comment Form if has error
  if ($('#commentForm').find('.error').length) {
    $('#commentForm').get(0).scrollIntoView();
  }

   // Testi Form
  $('#testiForm').hide();
  $('.submit-testi-btn').on('click', function(e){
    e.preventDefault();
    $('#testiForm').show();
    $(this).hide();
  });

  // reshow Testi Form if has error
  if ($('#testiForm').find('.error').length) {
    $('#testiForm').show();
    $('.submit-testi-btn').hide();
    $('#testiWrap').get(0).scrollIntoView();
  }

  // SUBCRIPTION AND PAYMENT METHOD BACKGROUND GREEN
  $('.sub-pay-container input:radio').on('click', function(){
    $(this).closest('.sub-pay-container').find('.active').removeClass('active');
    $(this).closest('.sub-pay-row').addClass('active'); 
  });
   // update payment modal
  $('input[name="payment"],input[name="subscription"]').change(function() {
    if ($('input[name="payment"]').is(":checked") && $('input[name="subscription"]').is(":checked")) {
      if ($("#payBtn").hasClass("hide")) {
        $('#payBtn').removeClass('hide');
      }   
    }
    if($('input#card').is(":checked")) {
      $('#payBtn').attr('href','#cardPaymentModal');
    } else if ($('input#ideal').is(":checked")) {
      $('#payBtn').attr('href','#idealPaymentModal');
    }
  });  

  $('input[name="subscription"]').change(function() {
      var planType = $(this).val();
      $('input[name="plan-type"]').val(planType);
  });
  // TOOLTIP
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
  // EDIT AND UPDATE USER PROFILE
  $('.profile-btn').on('click', function(){
    $('.old-profile-form').toggleClass('hide');
    $('.new-profile-form').toggleClass('hide');

    $(this).hide();
    $('.update-btn').show();     
  });

  if (document.getElementById('no-profile')) {
    $('.profile-btn').trigger('click');
  }

  // make hourly rate 2 decimals
  $( ".two-decimals" ).blur(function() {
    this.value = parseFloat(this.value).toFixed(2);
  });

  // disable hidden inputs on load
  $('.list-box-other').each(function (){
    if ($(this).hasClass( "hide" )){
      $(this).attr('disabled', 'disabled');
    } else {
      $(this).removeAttr('disabled');
    }
  });
  
  $('.other-clicked').on('click', function(){
    var thisOther = $('#'+this.id);
    var relatedInput = thisOther.next('label').next('.list-box-other');
    thisOther.next('label').next('.list-box-other').toggleClass('hide');

    // toggle disable on inputs by click
    if (relatedInput.hasClass( "hide" )){
      relatedInput.attr('disabled', 'disabled');
    } else {
      relatedInput.removeAttr('disabled');
    }
  });

  // generate select boxes based on number of children dropdown
  $('#numOfChildren').on('change',function(){

    var numItems = $('.child-gender').length;
    var num = $(this).val();

    if (num > numItems){
      for (var i = numItems; i < num; i++) {
        $( ".child-gender:first" ).clone().appendTo( ".children-genders" );
        $( ".child-age:first" ).clone().appendTo( ".children-ages" );
      }
    } else if (num < numItems) {
      for (var x = numItems; x > num; x--) {
        $( ".child-gender:last" ).remove();
        $( ".child-age:last" ).remove();
      }
    }
    
  });
  
  $('input[type=radio][name=job-desc]').change(function() {
      var jobDesc = $('input[type=radio][name=job-desc]:checked').val();
      $('input[type=hidden][name=job-desc]').val(jobDesc);
  });

  // dashboard tab


  //start of dashboard dropdown - VLSJ
  $('.ad-dropbutton,.ut-dropbutton').on('click',function(){
    $(this).next().toggleClass('show');
  });

  $('.ad-dropdown-item').on('click',function(){
    var selected = $(this).html();
    var current = $('.ad-dropdown-item').first().text();
    $(this).parent().prev().text(selected);
    $(this).parent().toggleClass('show');
    if(selected === 'Activate'){
      $(this).parent().parent().parent().next().html('<span class="green-text">'+ selected + "d" + '</span>');
      $(this).parent().prev().html('<span class="green-text">'+ selected  + '</span>');
    }else if(selected === 'Suspend'){
      $(this).parent().parent().parent().next().html('<span class="yellow-text">'+ selected + "ed" + '</span>');
      $(this).parent().prev().html('<span class="yellow-text">'+ selected  + '</span>');
    }else if (selected === 'Block'){
      $(this).parent().parent().parent().next().html('<span class="red-text">'+ selected + "ed" + '</span>');
      $(this).parent().prev().html('<span class="red-text">'+ selected  + '</span>');
    }
  });
  
  const $menu = $('.ut-dropdown,.ad-dropdown');

  $(document).mouseup(e => {
    if (!$menu.is(e.target) // if the target of the click isn't the container...
    && $menu.has(e.target).length === 0) // ... nor a descendant of the container
    {
      $menu.removeClass('show');
    }
  });

  $('.ad-dropbutton,ut-dropbutton').on('click', () => {
    $menu.toggleClass('show');
  });

  //end of dashboard dropdown
 
  // reshow modal if has error
  $('.auth-modal').each(function() {
    if ($(this).find('.invalid-feedback').length > 0 || $(this).find('.error').length > 0) {
      $(this).modal('show');
    }
  });

  $('.auth-modal .clear-field').click(function(){
    $('.auth-modal input[type="email"]').val('');
  });

  removeLoader(); 
  function removeLoader(){
      $( "#loadingDiv" ).fadeOut(500, function() {
        // fadeOut complete. Remove the loading div
        $( "#loadingDiv" ).remove(); //makes page more lightweight 
    });  
  }

  // reshow edit profile if has error
  if ($('.edit-profile-form').find('.help-block').length) {
    $('.old-profile-form').addClass('hide');
    $('.new-profile-form').removeClass('hide');
    $('.update-btn').show();
    $('.profile-btn').hide();
  }

  // delete contact modal
  $('#deleteContactModal').on('show.bs.modal', function(e) {
    var contactid = $(e.relatedTarget).data('contactid');
    var name = $(e.relatedTarget).data('name');
    $(e.currentTarget).find('input[name="contactid"]').val(contactid);
    $(e.currentTarget).find('input[name="name"]').val(name);
    $(e.currentTarget).find('.user-name').html(name);
  });

  var faqCategory = localStorage.getItem('faqCategory');
  if (!faqCategory) {
    localStorage.setItem('faqCategory', 'For Nanny');
    localStorage.setItem('activeTab', '#for-nanny');
  } 

  // keep selected tab active
  jQuery('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', jQuery(e.target).attr('href'));
    localStorage.setItem('faqCategory', jQuery(e.target).data('category'));

    // set value of category on creating faq question based on selected tab
    var faqCategory = localStorage.getItem('faqCategory');
    if (faqCategory) {
      jQuery('#inputCategory').val(faqCategory);
    }
  });

  var activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
     jQuery('a[href="' + activeTab + '"]').tab('show');
  }

  // blog comments
  $(".edt-comment").click(function(){
      var id = $(this).data('id');

      $('#comment'+id).hide();
      $('#updateForm'+id).show();
      $('#deleteForm'+id).hide();
  });

  // HELP TEXT
  $('.question-mark').on('click', function(){
    $('.help-text-city-content').addClass('active');
    $('.help-text-jd-content').removeClass('active');
  });
  $('.question-mark-jd').on('click', function(){
    $('.help-text-jd-content').addClass('active');
    $('.help-text-city-content').removeClass('active');

    if ($(window).width() <= 576) {
      $(this).parent().parent().addClass('active');
    }
  });

  $('.help-text-city-content .help-text-close').on('click', function(){
    $('.help-text-city-content').removeClass('active');
  });
  $('.help-text-jd-content .help-text-close').on('click', function(){
    $('.help-text-jd-content').removeClass('active');

    if ($(window).width() <= 576) {
      $(this).parent().parent().parent().removeClass('active');
    }
  });

  function readURL(input) {
      var url = input.value;
      var id = input.id;
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "svg")) {
          var reader = new FileReader();

          reader.onload = function (e) {

              if (id == 'edit-author-img') {
                $('#auth-photo-img').attr('src', e.target.result);
              } else if (id == 'edit-banner-img') {
                $('#blog-feat-img').attr('src', e.target.result); 
              } else {
                $('#profile-img').attr('src', e.target.result);
              }
          }
          reader.readAsDataURL(input.files[0]);
      }
  }

  $('#blog-feat-img, #auth-photo-img, #profile-img').on('load',function() {
    var height = $(this).height();
    var width = $(this).width();
    if (width > height) {
      $(this).css({'height':'200px','width':'auto'});

      $('.crop-pos-top, .crop-pos-bottom').hide();
      $('.crop-pos-left, .crop-pos-right').show();
    } else {
      $(this).css({'width':'200px','height':'auto'});

      $('.crop-pos-top, .crop-pos-bottom').show();
      $('.crop-pos-left, .crop-pos-right').hide();
    }
  }); 

  $("#edit-profile-img, #file-upload-profile, #edit-banner-img, #edit-author-img").change(function(){ 
      readURL(this);
  });

  $("#edit-profile-img").change(function(){ 
      $('#cropPos').removeClass('hide');
      $('#cropPosSelect').prop("disabled", false);
  });

  $("#cropPosSelect").change(function(){ 
      var pos = $(this).val();
      var img = $("#profile-img");
      var height = img.height();
      var width = img.width();

      if (pos == 'top') {
        img.css({'top':'-8px', 'bottom':'auto','left':'50%','right':'auto','transform': 'translate(-50%,0)'});
      } else if (pos == 'bottom') {
        img.css({'top':'auto', 'bottom':'-8px','left':'50%','right':'auto','transform': 'translate(-50%,0)'});
      } else if (pos == 'left') {
        img.css({'top':'50%', 'bottom':'auto','left':'-8px','right':'auto','transform': 'translate(0,-50%)'});
      } else if (pos == 'right') {
        img.css({'top':'50%', 'bottom':'auto','left':'auto','right':'-8px','transform': 'translate(0,-50%)'});
      } else {
        img.css({'top':'50%', 'bottom':'auto','left':'50%','right':'auto','transform': 'translate(-50%,-50%)'});
      }
  });

  $('#cookie-toggle').change(function() {
    if($(this).is(":checked")) {
      localStorage.setItem('ga_cookie_consent', '1');
    } else {
      localStorage.setItem('ga_cookie_consent', '0');
    }
  }).change(); 

  // INITIALIZE WYSIWYG for textarea
  tinyMCE.init({
    // General options
    mode : "specific_textareas",
    editor_selector : "mceEditor",
    min_height: 350,
    plugins: ['advlist autolink autoresize lists link code textcolor preview fullscreen'],
    toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | link | bullist numlist | outdent indent | removeformat',
    relative_urls : 0,
    remove_script_host : 0,
  });

});

// message notifications
setInterval("reloadNotification();",5000);   
function reloadNotification(){
  jQuery('.refresh').load(location.href + ' .reload');
}