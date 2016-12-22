window.filter = new Filter()
window.list = new List()
window.updload = new Upload()

$ '#left-content'
  .append filter.$el
  .append list.$el
  .append updload.$el

list.loadList()
