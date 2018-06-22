function header_sort(n) {
 var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
 table = document.getElementById("spend_tbl");
 switching = true;
 dir = "asc";
 while (switching) {
  switching = false;
  rows = table.getElementsByTagName("tr");
  for (i=1;i<(rows.length-1);i++) {
   shouldSwitch = false;
   x = rows[i].getElementsByTagName("td")[n];
   y = rows[i+1].getElementsByTagName("td")[n];
   if (dir == "asc") {
    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
     shouldSwitch = true;
     break;
    }
   } else if (dir == "desc") {
     if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
     shouldSwitch = true;
     break;
     }
    }
   }
   if (shouldSwitch) {
    rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
    switching = true;
    switchcount ++;
   } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function filter_search(x) {
 var input, filter, table, tr, td, i;
 var x2n=Number(x);
 input = document.getElementById("ft_srch");
 filter = input.value.toUpperCase();
 table = document.getElementById("spend_tbl");
 tr = table.getElementsByTagName("tr");
 for (i=0;i<tr.length;i++) {
  td = tr[i].getElementsByTagName("td")[x2n];
  if (td) {
    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
      tr[i].style.display = "";
    } else {
       tr[i].style.display = "none";
    }
  }
 }
}

function search_by_col() {
 var search_col = document.getElementById("ft_srch_sl").value;
 filter_search(search_col);
}

