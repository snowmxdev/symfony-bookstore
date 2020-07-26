
function calculatePrice() {
  var x = document.getElementsByClassName("bookQuantity");
  var y = document.getElementsByClassName("bookPrice");
  var z = document.getElementsByClassName("bookPriceOrder");
  var bookPriceQuantity = document.getElementsByClassName("bookPriceQuantity");
  var total = [];
  var totalOrder = 0;

  for(i=0; i < x.length; i++) {
    if(x[i].value <= 0 || x[i].value > 5 ) {
      return window.alert("Dozovoljena količina treba biti u rasponu od minimumu 1 knjige do maksimum 5!");
    }
     total[i] = x[i].value * y[i].value;
     totalOrder += total[i];
     total[i] = Math.round(total[i] * 100) / 100;
     total[i] = total[i].toFixed(2);
     document.getElementsByClassName("bookPriceQuantity")[i].innerHTML = total[i];
  }
  totalOrder = Math.round(totalOrder * 100) / 100;
  totalOrder = totalOrder.toFixed(2);
  document.getElementById("bookPriceOrder").innerHTML = totalOrder;
}

document.getElementById("calculate").onclick = function () { calculatePrice(); };
