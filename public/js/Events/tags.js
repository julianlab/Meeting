var x = 0;
document.getElementById('searchTags').onclick = function(){
  var tagName = document.getElementById('tag').value;
  var url = '{{ path("tags", { "nameLike": "tagName" })}}';
  url = url.replace("tagName", tagName);

  $.ajax({
    method: "GET",
    url: url,
    dataType: 'json',
    success: function(data){
      var tags = JSON.parse(data);
      var checkedTags = [];
      $("input:checkbox:not(:checked)").parent().remove();
      $.map($("input:checkbox:checked"), function(checkbox){
        checkedTags.push($(checkbox).attr("name"))
      });
      tags.forEach(function(tag){
        console.log(tag);
        if($.inArray(tag.name, checkedTags) != -1){}
        else{
          var tagButton = document.createElement("label");
          var tagCheckbox = document.createElement("input");
          tagButton.appendChild(tagCheckbox);
          tagButton.appendChild(document.createTextNode(tag.name));
          tagButton.className+="tag-button";
          tagButton.setAttribute("id", "checkboxLabel"+x);
          tagButton.setAttribute("onclick", "changeColor("+x+")");
          tagCheckbox.setAttribute("type", "checkbox");
          tagCheckbox.setAttribute("value", tag.id);
          tagCheckbox.setAttribute("class", "tagCheckbox");
          tagCheckbox.setAttribute("name", 'checkboxes[]');
          tagCheckbox.setAttribute("id", "checkboxId"+x);
          document.getElementById('tagsList').appendChild(tagButton);
          x++;
        }
      });
    }
  });
};
function changeColor(id){
  this.event.preventDefault();
  var checkbox = document.getElementById("checkboxId"+id);
  var tag = document.getElementById("checkboxLabel"+id);
  if(!checkbox.checked){
    tag.classList.add("tag-checked");
    checkbox.checked = true;
  }
  else{
    tag.classList.remove("tag-checked");
    checkbox.checked = false;
  }

}