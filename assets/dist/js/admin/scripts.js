"use strict";

(function ($, window, document, undefined) {
  /**
   * On document ready.
   */
  $(document).ready(function () {
    function findBeesUpdate(search, result) {
      var status = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
      var errors = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : {};
      // Hide spinner.
      xbeeHideSpinner('get-bees');

      if (status === 'error') {
        $('#xbee-search-bees-results').html(xbeeDocumentAdminParams.messages.errorFindBees);
        return;
      } // Flush results.


      $('#xbee-search-bees-results').html('');
      search = search.toLowerCase();
      var matches = [];
      result.forEach(function (res) {
        if (search != '') {
          var sLabel = res.label.toLowerCase().indexOf(search) > -1;
          var sSystemName = res.bee_system_name.toLowerCase().indexOf(search) > -1;
          var sDescription = res.description.toLowerCase().indexOf(search) > -1;

          if (sLabel || sSystemName || sDescription) {
            matches.push(res);
          }
        }
      });

      if (matches.length > 0) {
        $('#xbee-search-bees-results').append('<table class="wp-list-table widefat striped"><thead><tr><th>' + xbeeDocumentAdminParams.text.beeName + '</th><th>' + xbeeDocumentAdminParams.text.beeSystemName + '</th><th>' + xbeeDocumentAdminParams.text.beeDescription + '</th></tr></thead><tbody></tbody></table>');
        matches.forEach(function (match) {
          $('#xbee-search-bees-results table tbody').append(findBeesMatch(match));
        });
      } else if (search.length > 0) {
        $('#xbee-search-bees-results').html(xbeeDocumentAdminParams.messages.errorFindBeesNoBees);
      }
    }

    function findBeesMatch(match) {
      var beeLabel = '<td>' + (match.label ? match.label : match.bee_system_name) + '</td>';
      var beeSystemName = '<td><code>' + match.bee_system_name + '</code></td>';
      var beeDescription = '<td>' + match.description + '</td>';
      var el = '<tr>' + beeLabel + beeSystemName + beeDescription + '</tr>';
      return el;
    } // Load overlay.


    xbeeLoadOverlay();
    $('.xbee-copy-text').on('click', function () {
      var text = $('#' + $(this).data('copy') + ' code').text();
      var tempTextarea = document.createElement('textarea');
      tempTextarea.value = text;
      document.body.appendChild(tempTextarea);
      tempTextarea.select();
      document.execCommand('copy');
      document.body.removeChild(tempTextarea);
    }); // Load color picker.

    $('.wrap.xbee .color-field').wpColorPicker({
      color: false,
      mode: 'hsl',
      controls: {
        horiz: 's',
        vert: 'l',
        strip: 'h'
      },
      hide: true,
      change: function change() {
        updateDropZonePreview();
      },
      clear: function clear() {
        updateDropZonePreview();
      },
      border: false,
      target: false,
      width: 260,
      palettes: false
    });
    $('.wp-color-result-text').text(''); // Update dropzone preview.

    updateDropZonePreview();
    $('#xbee-dropzone-layout input, #xbee-dropzone-layout select').on('change paste keyup', function () {
      updateDropZonePreview();
    });

    function updateDropZonePreview() {
      var baseFontSize = $('[name="xbee_document_dropzone_base_font_size"]').val();
      var baseFontSizeUnit = $('[name="xbee_document_dropzone_base_font_size_unit"]').val();
      var borderRadius = $('[name="xbee_document_dropzone_border_radius"]').val();
      var borderRadiusUnit = $('[name="xbee_document_dropzone_border_radius_unit"]').val();
      var textColor = $('[name="xbee_document_dropzone_text_color"]').val();
      var primaryColor = $('[name="xbee_document_dropzone_primary_color"]').val();
      var secondaryColor = $('[name="xbee_document_dropzone_secondary_color"]').val();
      $('#xbee-dropzone-preview').css('color', textColor);
      $('#xbee-dropzone-preview').css('background-color', secondaryColor);
      $('#xbee-dropzone-preview').css('font-size', baseFontSize + baseFontSizeUnit);
      $('#xbee-dropzone-preview').css('border-radius', borderRadius + borderRadiusUnit);
      $('#xbee-dropzone-preview .xbee-dropzone').css('border-radius', borderRadius + borderRadiusUnit);
      $('#xbee-dropzone-preview .xbee-dropzone').css('border-color', primaryColor);
      $('#xbee-dropzone-preview .xbee-upload-icon').attr('fill', primaryColor);
      $('#xbee-dropzone-preview .xbee-upload-icon path').attr('fill', primaryColor);
    } // Search bees.


    var beeResults = [];
    var requestingData = false;
    $('#xbee-search-bees').on('change paste keyup keydown', function (e) {
      // Show spinner.
      xbeeShowSpinner('get-bees'); // Flush results.

      $('#xbee-search-bees-results').html('');
      var search = $(e.target).val();

      if (search === '') {
        findBeesUpdate(search, beeResults ? beeResults : []);
        return;
      }

      if ($.isEmptyObject(beeResults) && !requestingData) {
        // Request data.
        var data = {
          'action': 'xbee_get_bees'
        };
        requestingData = true;
        $.ajax({
          url: xbeeDocumentAdminParams.ajaxUrl,
          method: 'post',
          data: data,
          success: function success(response) {
            response = JSON.parse(response);

            if (!response.result) {
              requestingData = false;
            }

            beeResults = response.result;
            findBeesUpdate($(e.target).val(), response.result, response.status, response.errors);
          },
          error: function error() {
            requestingData = false;
            findBeesUpdate($(e.target).val(), response.result, response.status, response.errors);
          }
        });
      } else if (!$.isEmptyObject(beeResults)) {
        findBeesUpdate($(e.target).val(), beeResults);
      }
    });
  });
})(jQuery, window, document);