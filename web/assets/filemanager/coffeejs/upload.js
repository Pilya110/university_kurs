// Generated by CoffeeScript 1.11.1
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  window.Upload = (function(superClass) {
    extend(Upload, superClass);

    function Upload() {
      return Upload.__super__.constructor.apply(this, arguments);
    }

    Upload.prototype.className = 'col-md-12';

    Upload.prototype.timeout = null;

    Upload.prototype.events = {
      'click [name="btn-upload"]': 'clickUpload',
      'drop .upload-drop-file': 'dropEvent'
    };

    Upload.prototype.initialize = function() {
      return this.render();
    };

    Upload.prototype.render = function() {
      var self;
      self = this;
      $(window).on('dragover', function(e) {
        self.dragOver(e);
        e.stopPropagation();
        return e.preventDefault();
      }).on('dragleave', function(e) {
        self.dragLeave(e);
        return e.preventDefault();
      }).on('drop', function(e) {
        self.disableDropContainer();
        e.stopPropagation();
        return e.preventDefault();
      });
      return this.$el.html(document.getElementById('upload-template').innerHTML);
    };

    Upload.prototype.dragOver = function(e) {
      var cls, dt;
      if (this.timeout) {
        clearTimeout(this.timeout);
      }
      cls = 'upload-drop-file-active';
      dt = e.originalEvent.dataTransfer;
      if (dt.types && !this.$el.hasClass(cls)) {
        if (-1 !== dt.types.indexOf('Files')) {
          return this.$el.addClass(cls);
        }
      }
    };

    Upload.prototype.dragLeave = function(e) {
      var self;
      if ('HTML' === e.target.tagName) {
        self = this;
        return this.timeout = setTimeout(function() {
          return self.disableDropContainer();
        }, 100);
      }
    };

    Upload.prototype.clickUpload = function() {
      var self;
      self = this;
      return this.$el.find('[name="upload-file"]').change(function(e) {
        var file, files, i, len, results, vFile;
        files = e.target.files;
        results = [];
        for (i = 0, len = files.length; i < len; i++) {
          file = files[i];
          vFile = new UploadProgresBar(file);
          results.push(self.$el.append(vFile.$el));
        }
        return results;
      }).click();
    };

    Upload.prototype.disableDropContainer = function() {
      var cls;
      cls = 'upload-drop-file-active';
      if (this.$el.hasClass(cls)) {
        return this.$el.removeClass(cls);
      }
    };

    Upload.prototype.dropEvent = function(e) {
      var file, files, i, len, results, self, vFile;
      self = this;
      this.disableDropContainer();
      e.preventDefault();
      files = e.originalEvent.dataTransfer.files;
      results = [];
      for (i = 0, len = files.length; i < len; i++) {
        file = files[i];
        vFile = new UploadProgresBar(file);
        results.push(this.$el.append(vFile.$el));
      }
      return results;
    };

    return Upload;

  })(Backbone.View);

  window.UploadProgresBar = (function(superClass) {
    extend(UploadProgresBar, superClass);

    function UploadProgresBar() {
      return UploadProgresBar.__super__.constructor.apply(this, arguments);
    }

    UploadProgresBar.prototype.className = 'col-md-12';

    UploadProgresBar.prototype.file = null;

    UploadProgresBar.prototype.template = _.template(document.getElementById('upload-file-status').innerHTML);

    UploadProgresBar.prototype.initialize = function(file1) {
      this.file = file1;
      return this.render();
    };

    UploadProgresBar.prototype.render = function() {
      var formData, nmbrOiler, self, xhr;
      if (!this.checkTypeFile()) {
        throw new Error('Формат файла не поддерживается');
      }
      self = this;
      this.$el.html(this.template({
        name: this.file.name
      }));
      nmbrOiler = prompt('Введите номер скважины для файла: ' + this.file.name);
      xhr = new XMLHttpRequest();
      xhr.upload.addEventListener('progress', function(event) {
        return self.uploadProgress(event);
      }, false);
      xhr.open('POST', '/upload_file');
      formData = new FormData();
      formData.append('file', this.file);
      formData.append('oiler', nmbrOiler);
      formData.processData = false;
      formData.contentType = false;
      return xhr.send(formData);
    };

    UploadProgresBar.prototype.checkTypeFile = function() {
      return true;

      /*res = false
      for type in ['jpg', 'pdf', 'txt']
        if -1 isnt @file.name.indexOf(type)
          res = true
          break
      res
       */
    };

    UploadProgresBar.prototype.uploadProgress = function(event) {
      var percent, self;
      percent = parseInt(event.loaded / event.total * 100);
      this.$el.find('.progress-bar').css('width', percent + '%');
      if (100 === percent) {
        self = this;
        return setTimeout(function() {
          self.remove();
          return list.loadList();
        }, 1000);
      }
    };

    UploadProgresBar.prototype.stateChange = function(event) {
      var self;
      self = this;
      return setTimeout(function() {
        return self.remove();
      }, 1000);
    };

    return UploadProgresBar;

  })(Backbone.View);

}).call(this);

//# sourceMappingURL=upload.js.map
