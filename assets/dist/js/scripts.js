"use strict";

(function ($, window, document, undefined) {
  /**
   * Create a dropzone area.
   *
   * @param {array} params Dropzone parameters.
   */
  window.xbeeCreateDropzone = function xbeeCreateDropzone(params) {
    var dropzone = '.xbee-document #xbee-dropzone-' + params.id;

    function addResponse(container, content) {
      var close = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
      var response = '<div class="xbee-message">' + content + '</div>';

      if (close) {
        response += '<span class="xbee-close"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><path fill="' + xbeeDocumentParams.primaryColor + '" fill-rule="evenodd" d="M16 1.6L14.4 0 8 6.4 1.6 0 0 1.6 6.4 8 0 14.4 1.6 16 8 9.6l6.4 6.4 1.6-1.6L9.6 8z"/></svg></span>';
      }

      $(container).find('.xbee-response').css('display', 'table').html('').append(response); // Listen to clicks on the close icon.

      $(container).find('.xbee-response .xbee-close').on('click', function () {
        $(container).find('.xbee-response').css('display', 'none').html('');
      });
    }

    function updateProgress(container, progress) {
      var progressPercent = $(container).find('.xbee-response .xbee-progress-percent .xbee-percent');
      var progressBar = $(container).find('.xbee-response .xbee-progress-bar .xbee-progress');
      var currentProgress = parseInt($(progressPercent).html());
      var updatedProgress = currentProgress + progress;

      var _loop = function _loop(i) {
        setTimeout(function () {
          // Update progress percentage.
          $(progressPercent).html(i); // Update progress bar.

          $(progressBar).css('width', i + '%');
        }, 300);
      };

      for (var i = currentProgress; i <= updatedProgress; i++) {
        _loop(i);
      }
    } // Elements.


    var ElementIconDelete = '<img src="' + xbeeDocumentParams.images.iconDelete + '" />';
    var ElementIconXcooBee = '<img class="icon-xcoobee" src="' + xbeeDocumentParams.images.iconXcooBee + '" />';
    var ElementError = '<img class="icon-error" src="' + xbeeDocumentParams.images.iconError + '" />';
    var ElementLoader = '<img class="loader" src="' + xbeeDocumentParams.images.loader + '"></img>';
    var ElementPreview = '<div class="xbee-preview"><div class="xbee-image"><img data-dz-thumbnail /></div><div class="xbee-details"><div class="xbee-filename"><span data-dz-name></span></div><div class="xbee-size" data-dz-size></div></div></div>';
    var ElementProgress = '<div class="xbee-progress-percent"><span class="xbee-percent">0</span>%</div>';
    var ElementProgressBar = '<div class="xbee-progress-bar"><div class="xbee-progress" style="background-color:' + xbeeDocumentParams.primaryColor + ';"></div></div>';
    new Dropzone(dropzone, {
      paramName: 'files',
      uploadMultiple: true,
      autoProcessQueue: false,
      previewsContainer: dropzone + ' .xbee-previews',
      clickable: dropzone + ' .btn-browse',
      addRemoveLinks: true,
      thumbnailHeight: 40,
      thumbnailWidth: 40,
      acceptedFiles: params.acceptedFiles,
      url: xbeeDocumentParams.ajaxUrl,
      dictRemoveFile: ElementIconDelete,
      dictCancelUpload: ElementIconDelete,
      previewTemplate: ElementPreview,
      init: function init() {
        var self = this;
        var dropzone = $(self.element);
        var errors = [];
        var progress = 0; // On submission.

        $(dropzone).on('submit', function (e) {
          e.preventDefault();
          e.stopPropagation(); // Display progress bar.

          var content = ElementProgress + ElementProgressBar;
          addResponse(dropzone, content, false);
          var requireFileUpload = params.beesRequireFileUpload.indexOf(params.beeName) !== -1; // The hired bee does not require file upload.

          if (!requireFileUpload) {
            updateProgress(dropzone, 25);
            $.ajax({
              url: xbeeDocumentParams.ajaxUrl,
              method: 'post',
              data: {
                'action': 'xbee_document_upload',
                'data': $(dropzone).serialize()
              },
              success: function success(res) {
                // Reset form.
                self.removeAllFiles(true);
                $(dropzone)[0].reset();
                updateProgress($(self.element), 25);

                if (res.status === 'success') {
                  updateProgress($(self.element), 50);
                  var message = ElementIconXcooBee + '<p>' + params.successText + '</p>';
                  addResponse(dropzone, message, true);
                } else {
                  var _message = ElementError + '<p>' + xbeeDocumentParams.messages.errorSendFiles + '</p>';

                  addResponse(dropzone, _message, true);
                }
              },
              error: function error() {}
            }); // The hired bee require file upload.
          } else {
            // Stop if no files selected.
            if (self.getQueuedFiles().length === 0) {
              var message = ElementError + '<p>' + xbeeDocumentParams.messages.errorSendNoFiles + '</p>';
              addResponse(dropzone, message, true);
              return;
            } // If no errors, process files.


            if (errors.length === 0) {
              var fileNames = self.files.map(function (file) {
                return file.name;
              });
              var data = {
                'action': 'xbee_document_send',
                'files': fileNames
              };
              updateProgress(dropzone, 25);
              $.ajax({
                url: xbeeDocumentParams.ajaxUrl,
                method: 'post',
                data: data,
                success: function success(response) {
                  if (response.code === 200) {
                    var policies = Object.values(response.result);
                    updateProgress($(self.element), 25);
                    XcooBee.sdk.Utilities.uploadFiles(self.files, policies).then(function () {
                      updateProgress($(self.element), 25);
                      $.ajax({
                        url: xbeeDocumentParams.ajaxUrl,
                        method: 'post',
                        data: {
                          'action': 'xbee_document_upload',
                          'files': self.files.map(function (file) {
                            return file.name;
                          }),
                          'data': $(dropzone).serialize()
                        },
                        success: function success(res) {
                          // Reset form.
                          self.removeAllFiles(true);
                          $(dropzone)[0].reset();

                          if (res.status === 'success') {
                            updateProgress($(self.element), 25);

                            var _message2 = ElementIconXcooBee + '<p>' + params.successText + '</p>';

                            addResponse(dropzone, _message2, true);
                          } else {
                            var _message3 = ElementError + '<p>' + xbeeDocumentParams.messages.errorSendFiles + '</p>';

                            addResponse(dropzone, _message3, true);
                          }
                        },
                        error: function error() {}
                      });
                    }).catch(function (err) {
                      return console.error(err);
                    });
                  } else {
                    console.error(response);
                  }
                },
                error: function error() {}
              });
            } else {
              errors.forEach(function (err) {
                console.log(err);
              });
            }
          }
        }); // Validate added files.

        this.on('addedfile', function (file) {
          // Validate file extension.
          var ext = '.' + file.name.split('.').pop().toLowerCase();
          var accepted = params.acceptedFiles.split(",").map(function (fileExt) {
            return fileExt.toLowerCase();
          });

          if (accepted.length > 0 && !accepted.includes(ext)) {
            accepted = accepted.split(',');
            this.removeFile(file);
            var message = ElementError + '<p>' + xbeeDocumentParams.messages.errorAcceptedFileExtensions + ' ' + accepted.join(', ') + '</p>';
            addResponse(dropzone, message, true);
          }
        }); // Pass data.

        this.on('sending', function (file, xhr, formData) {
          formData.append('xbee_bee_name', params.beeName);
        });
      }
    });
  };
  /**
   * On document ready.
   */


  $(document).ready(function () {
    /**
     * Dynamically set CSS values.
     */
    $('.xbee-document').each(function () {
      var xbeeDoc = $(this);
      var dropzone = $(this).find('.xbee-dropzone');
      var actions = $(this).find('.xbee-actions');
      var actionsHeight = actions.outerHeight(); // Dropzone.

      dropzone.css('padding', parseInt(actionsHeight + 15) + 'px'); // Response div.

      $(this).on('DOMSubtreeModified', '.xbee-dropzone', function () {
        dropzone.find('.xbee-response').css('width', dropzone.innerWidth() + 'px');
        dropzone.find('.xbee-response').css('height', dropzone.innerHeight() + 'px');
      });
    });
  });
})(jQuery, window, document);