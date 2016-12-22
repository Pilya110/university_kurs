class window.Upload extends Backbone.View
  className: 'col-md-12'
  timeout: null
  events: {
    'click [name="btn-upload"]': 'clickUpload'
    'drop .upload-drop-file': 'dropEvent'
  }

  initialize: () ->
    @render()

  render: () ->
    self = @
    $ window
      .on 'dragover', (e) ->
        self.dragOver e
        e.stopPropagation()
        e.preventDefault()
      .on 'dragleave', (e) ->
        self.dragLeave e
        e.preventDefault()
      .on 'drop', (e) ->
        self.disableDropContainer()
        e.stopPropagation()
        e.preventDefault()
    @$el.html document.getElementById('upload-template').innerHTML

  dragOver: (e) ->
    clearTimeout @timeout if @timeout
    cls = 'upload-drop-file-active'
    dt = e.originalEvent.dataTransfer
    if dt.types and not @$el.hasClass cls
      if -1 isnt dt.types.indexOf 'Files'
        @$el.addClass cls

  dragLeave: (e) ->
    if 'HTML' is e.target.tagName
      self = @
      @timeout = setTimeout () ->
        self.disableDropContainer()
      , 100

  clickUpload: () ->
    self = @
    @$el.find '[name="upload-file"]'
      .change (e) ->
        files = e.target.files
        for file in files
          vFile = new UploadProgresBar file
          self.$el.append vFile.$el
      .click()

  disableDropContainer: () ->
    cls = 'upload-drop-file-active'
    @$el.removeClass cls if @$el.hasClass cls

  dropEvent: (e) ->
    self = @
    @disableDropContainer()
    e.preventDefault()
    files = e.originalEvent.dataTransfer.files

    for file in files
      vFile = new UploadProgresBar file
      @$el.append vFile.$el



class window.UploadProgresBar extends Backbone.View
  className: 'col-md-12'
  file: null
  template: _.template document.getElementById('upload-file-status').innerHTML
  initialize: (@file) ->
    @render()

  render: () ->
    throw new Error 'Формат файла не поддерживается' if not @checkTypeFile()
    self = @
    @$el.html(@template {name: @file.name})
    xhr = new XMLHttpRequest()
    xhr.upload.addEventListener 'progress', (event) ->
      self.uploadProgress event
    , false
    xhr.open 'POST', '/upload_file'
    formData = new FormData()
    formData.append 'file', @file
    formData.processData = false
    formData.contentType = false
    xhr.send formData

  checkTypeFile: () ->
    return true
    ###res = false
    for type in ['jpg', 'pdf', 'txt']
      if -1 isnt @file.name.indexOf(type)
        res = true
        break
    res###

  uploadProgress: (event) ->
    percent = parseInt(event.loaded / event.total * 100)
    @$el.find('.progress-bar').css 'width', percent+'%'
    if 100 is percent
      self = @
      setTimeout () ->
        self.remove()
        list.loadList()
      , 1000

  stateChange: (event) ->
    self = @
    setTimeout () ->
      self.remove()
    , 1000
#    if 4 is event.target.readyState
#      if 200 is event.target.status
#        1
#      else
#        0