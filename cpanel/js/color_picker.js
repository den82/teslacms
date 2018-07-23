var colorhex = "#FF0000";
  var color = "#FF0000";
  var colorObj = w3color(color);
  function mouseOverColor(hex) {
      document.getElementById("divpreview").style.visibility = "visible";
      document.getElementById("divpreview").style.backgroundColor = hex;
      document.body.style.cursor = "pointer";
  }
  function mouseOutMap() {
      if (hh == 0) {
          document.getElementById("divpreview").style.visibility = "hidden";
      } else {
        hh = 0;
      }
      document.getElementById("divpreview").style.backgroundColor = colorObj.toHexString();
      document.body.style.cursor = "";
  }
  var hh = 0;
  function clickColor(hex, seltop, selleft, html5) {
      var c, cObj, colormap, areas, i, areacolor, cc;
      if (html5 && html5 == 5)  {
          c = document.getElementById("html5colorpicker").value;
      } else {
          if (hex == 0)  {
              c = document.getElementById("entercolor").value;
          } else {
              c = hex;
          }
      }
      cObj = w3color(c);
      colorhex = cObj.toHexString();
      if (cObj.valid) {
          clearWrongInput();
      } else {
          wrongInput();
          return;
      }
      r = cObj.red;
      g = cObj.green;
      b = cObj.blue;
      document.getElementById("colornamDIV").innerHTML = (cObj.toName() || "");
      document.getElementById("colorhexDIV").innerHTML = cObj.toHexString();
      document.getElementById("colorrgbDIV").innerHTML = cObj.toRgbString();
      document.getElementById("colorhslDIV").innerHTML = cObj.toHslString();    
      if ((!seltop || seltop == -1) && (!selleft || selleft == -1)) {
          colormap = document.getElementById("colormap");
          areas = colormap.getElementsByTagName("AREA");
          for (i = 0; i < areas.length; i++) {
              areacolor = areas[i].getAttribute("onmouseover").replace('mouseOverColor("', '');
              areacolor = areacolor.replace('")', '');
              if (areacolor.toLowerCase() == colorhex) {
                  cc = areas[i].getAttribute("onclick").replace(')', '').split(",");
                  seltop = Number(cc[1]);
                  selleft = Number(cc[2]);
              }
          }
      }
      if ((seltop+200)>-1 && selleft>-1) {
          document.getElementById("selectedhexagon").style.top=seltop + "px";
          document.getElementById("selectedhexagon").style.left=selleft + "px";
          document.getElementById("selectedhexagon").style.visibility="visible";
    } else {
          document.getElementById("divpreview").style.backgroundColor = cObj.toHexString();
          document.getElementById("selectedhexagon").style.visibility = "hidden";
    }
      document.getElementById("selectedcolor").style.backgroundColor = cObj.toHexString();
      document.getElementById("html5colorpicker").value = cObj.toHexString();  
    document.getElementById('slideRed').value = r;
    document.getElementById('slideGreen').value = g;
    document.getElementById('slideBlue').value = b;
    changeRed(r);changeGreen(g);changeBlue(b);
    changeColor();
    document.getElementById("fixed").style.backgroundColor = cObj.toHexString();
  }