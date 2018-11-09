/**
 * WP Reset
 * https://wpreset.com/
 * (c) WebFactory Ltd, 2017-2018
 */


jQuery(document).ready(function($) {
  // init tabs
  $('#wp-reset-tabs').tabs({
    activate: function(event, ui) {
      localStorage.setItem('wp-reset-tabs', $('#wp-reset-tabs').tabs('option', 'active'));
    },
    active: localStorage.getItem('wp-reset-tabs') || 0
  }).show();


  // delete transients
  $('.tools_page_wp-reset').on('click', '#delete-transients', 'click', function(e) {
    e.preventDefault();

    run_tool(this, 'delete_transients');

    return false;
  }); // delete transients


  // delete uploads
  $('.tools_page_wp-reset').on('click', '#delete-uploads', 'click', function(e) {
    e.preventDefault();

    run_tool(this, 'delete_uploads');

    return false;
  }); // delete uploads


  // delete themes
  $('.tools_page_wp-reset').on('click', '#delete-themes', 'click', function(e) {
    e.preventDefault();
  
    run_tool(this, 'delete_themes');

    return false;
  }); // delete themes


  // delete plugins
  $('.tools_page_wp-reset').on('click', '#delete-plugins', 'click', function(e) {
    e.preventDefault();
  
    run_tool(this, 'delete_plugins');

    return false;
  }); // delete plugins


  // compare snapshot
  $('#wpr-snapshots').on('click', '.compare-snapshot', 'click', function(e) {
    e.preventDefault();
    uid = $(this).data('ss-uid');
    button = $(this);
  
    block_ui($(button).data('wait-msg'));
    $.get({
      url: ajaxurl,
      data: {
        action: 'wp_reset_run_tool',
        _ajax_nonce: wp_reset.nonce_run_tool,
        tool: 'compare_snapshots',
        extra_data: uid
      }
    }).always(function(data) {
      swal.close();
    }).done(function(data) {
      if (data.success) {
        msg = $(button).data('title').replace('%s', $(button).data('name'));
        swal({
          width: '90%',
          title: msg,
          html: data.data,
          showConfirmButton: false,
          allowEnterKey:false,
          focusConfirm: false,
          showCloseButton: true,
          customClass: 'compare-snapshots'
        });        
      } else {
        swal({ type: 'error', title: wp_reset.documented_error + ' ' + data.data });
      }
    }).fail(function(data) {
      swal({ type: 'error', title: wp_reset.undocumented_error });
    });

    return false;
  }); // compare snapshot


  // restore snapshot
  $('#wpr-snapshots').on('click', '.restore-snapshot', 'click', function(e) {
    e.preventDefault();
    uid = $(this).data('ss-uid');
  
    run_tool(this, 'restore_snapshot', uid);

    return false;
  }); // restore snapshot


  // download snapshot
  $('#wpr-snapshots').on('click', '.download-snapshot', 'click', function(e) {
    e.preventDefault();
    uid = $(this).data('ss-uid');
    button = this;

    block_ui($(this).data('wait-msg'));
    $.get({
      url: ajaxurl,
      data: {
        action: 'wp_reset_run_tool',
        _ajax_nonce: wp_reset.nonce_run_tool,
        tool: 'download_snapshot',
        extra_data: uid
      }
    }).always(function(data) {
      swal.close();
    }).done(function(data) {
      if (data.success) {
        msg = $(button).data('success-msg').replace('%s', data.data);
        swal({ type: 'success', title: msg });
      } else {
        swal({ type: 'error', title: wp_reset.documented_error + ' ' + data.data });
      }
    }).fail(function(data) {
      swal({ type: 'error', title: wp_reset.undocumented_error });
    });

    return false;
  }); // downlod snapshot


  // delete snapshot
  $('#wpr-snapshots').on('click', '.delete-snapshot', 'click', function(e) {
    e.preventDefault();
    uid = $(this).data('ss-uid');
  
    run_tool(this, 'delete_snapshot', uid);

    return false;
  }); // delete snapshot


  // create snapshot
  $('.tools_page_wp-reset').on('click', '.create-new-snapshot', 'click', function(e) {
    e.preventDefault();
    button = $('#create-new-snapshot-primary');
  
    swal({ title: $(button).data('title'),
      type: 'question',
      text: $(button).data('text'),
      input: 'text',
      inputPlaceholder: $(button).data('placeholder'),
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText: $(button).data('btn-confirm'),
      cancelButtonText: wp_reset.cancel_button,
      width: 600
    }).then((result) => { 
      if (typeof result.value != 'undefined') {
        block = block_ui($(button).data('msg-wait'));
        $.get({
          url: ajaxurl,
          data: {
            action: 'wp_reset_run_tool',
            _ajax_nonce: wp_reset.nonce_run_tool,
            tool: 'create_snapshot',
            extra_data: result.value
          }
        }).always(function(data) {
          swal.close();
        }).done(function(data) {
          if (data.success) {
            swal({ type: 'success', title: $(button).data('msg-success') }).then((result) => {
              location.reload();
            });
          } else {
            swal({ type: 'error', title: wp_reset.documented_error + ' ' + data.data });
          }
        }).fail(function(data) {
          swal({ type: 'error', title: wp_reset.undocumented_error });
        });
      } // if confirmed
    });

    return false;
  }); // create snapshot

  // show/hide extra table info in snapshot diff
  $('body.tools_page_wp-reset').on('click', '.header-row', function(e) {
    e.preventDefault();

    parent = $(this).parents('div.wpr-table-container > table > tbody');
    $(' > tr:not(.header-row)', parent).toggleClass('hidden');

    $('span.dashicons', parent).toggleClass('dashicons-arrow-down-alt2').toggleClass('dashicons-arrow-up-alt2');

    return false;
  }); // show hide extra info in diff


  // standard way of running a tool, with confirmation, loading and success message
  function run_tool(button, tool_name, extra_data) {
    confirm_action(wp_reset.confirm_title, $(button).data('text-confirm'), $(button).data('btn-confirm'), wp_reset.cancel_button)
      .then((result) => {
        if (result.value) {
          block = block_ui($(button).data('text-wait'));
          $.get({
            url: ajaxurl,
            data: {
              action: 'wp_reset_run_tool',
              _ajax_nonce: wp_reset.nonce_run_tool,
              tool: tool_name,
              extra_data: extra_data
            }
          }).always(function(data) {
            swal.close();
          }).done(function(data) {
            if (data.success) {
              msg = $(button).data('text-done').replace('%n', data.data);
              swal({ type: 'success', title: msg }).then(() => {
                if (tool_name == 'restore_snapshot') {
                  location.reload();
                }
              });
              if (tool_name == 'delete_snapshot') {
                $('#wpr-ss-' + extra_data).remove();
                if ($('#wpr-snapshots tr').length <= 1) {
                  $('#wpr-snapshots').hide();
                  $('#ss-no-snapshots').show();
                }
              }
            } else {
              swal({ type: 'error', title: wp_reset.documented_error + ' ' + data.data });
            }
          }).fail(function(data) {
            swal({ type: 'error', title: wp_reset.undocumented_error });
          });
        } // if confirmed
      }
    );
  } // run_tool


  // display a message while an action is performed
  function block_ui(message) {
    tmp = swal({ text: message,
      type: false,
      imageUrl: wp_reset.icon_url,
      onOpen: () => { $(swal.getImage()).addClass('rotating'); },
      imageWidth: 100,
      imageHeight: 100,
      imageAlt: message,
      allowOutsideClick: false,
      allowEscapeKey: false,
      allowEnterKey: false,
      showConfirmButton: false,
    });

    return tmp;
  } // block_ui


  // display dialog to confirm action
  function confirm_action(title, question, btn_confirm, btn_cancel) {
    tmp = swal({ title: title,
      type: 'question',
      html: question,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText: btn_confirm,
      cancelButtonText: btn_cancel,
      confirmButtonColor: '#dd3036',
      width: 600
    });

    return tmp;
  } // confirm_action


  $('#wp_reset_form').on('submit', function(e, confirmed) {
    if (!confirmed) {
      $('#wp_reset_submit').trigger('click');
      e.preventDefault();
      return false;
    }

    $(this).off('submit').submit();
    return true;
  }); // bypass default submit behaviour


  $('#wp_reset_submit').click(function(e) {
    if ($('#wp_reset_confirm').val() !== 'reset') {
      swal({ title: wp_reset.invalid_confirmation_title,
             text: wp_reset.invalid_confirmation,
             type: 'error',
             confirmButtonText: wp_reset.ok_button,
      });
      
      e.preventDefault();
      return false;
    } // wrong confirmation code

    message = wp_reset.confirm1 + '<br>' + wp_reset.confirm2;
    swal({ title: wp_reset.confirm_title,
           type: 'question',
           html: message,
           showCancelButton: true,
           focusConfirm: false,
           confirmButtonText: wp_reset.confirm_button,
           cancelButtonText: wp_reset.cancel_button,
           confirmButtonColor: '#dd3036',
           width: 600
    }).then((result) => {
      if (result.value === true) {
        block_ui(wp_reset.doing_reset);
        $('#wp_reset_form').trigger('submit', true);
      }
    });

    e.preventDefault();
    return false;
  }); // reset submit


  // collapse / expand card
  $('.card').on('click', '.toggle-card', function(e) {
    e.preventDefault();

    card = $(this).parents('.card').toggleClass('collapsed');
    $('.dashicons', this).toggleClass('dashicons-arrow-up-alt2').toggleClass('dashicons-arrow-down-alt2');
    $(this).blur();

    cards = localStorage.getItem('wp-reset-cards');
    if (cards == null) {
      cards = new Object();
    } else {
      cards = JSON.parse(cards);
    }

    if (card.hasClass('collapsed')) {
      cards[card.attr('id')] = 'collapsed';
    } else {
      cards[card.attr('id')] = 'expanded';
    }
    localStorage.setItem('wp-reset-cards', JSON.stringify(cards));

    return false;
  }); // toggle-card

  
  // init cards; collapse those that need collapsing
  cards = localStorage.getItem('wp-reset-cards');
  if (cards != null) {
    cards = JSON.parse(cards);
  }
  $.each(cards, function(card_name, card_value) {
    if (card_value == 'collapsed') {
      $('a.toggle-card', '#' + card_name).trigger('click');
    }
  });

  
  // dismiss notice / pointer
  $('.wpr-dismiss-notice').on('click', function(e) {
    notice_name = $(this).data('notice');
    if (!notice_name) {
      return true;
    }

    if (notice_name == 'geoip_tab') {
      $('#wp-reset-tabs').tabs('option', 'active', 0).tabs('disable', 3);
      $('#wp-reset-tabs li:eq(3)').remove();
      $('#wp-reset-tabs').tabs('refresh');
    }

    $.get(ajaxurl, { notice_name: notice_name,
                     _ajax_nonce: wp_reset.nonce_dismiss_notice,
                     action: 'wp_reset_dismiss_notice'
    });

    $(this).parents('.notice-wrapper').fadeOut();

    e.preventDefault();
    return false;
  }); // dismiss notice
}); // onload
