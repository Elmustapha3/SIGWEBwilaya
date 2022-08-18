function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("layerstable");
  tr = table.getElementsByTagName("tr");
  td = table.getElementsByTagName("td");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    for(j = 0; j < td.length; j++){
    tdd = tr[i].getElementsByTagName("td")[j];
    if (tdd) {
      txtValue = tdd.textContent || tdd.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
}