<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <style>

        body {
          background: rgb(40,40,40);
          overflow: hidden;
        }

        p {
            font-family: "Tahoma", cursive;
            font-size: 80px;
            margin: 10vh 0 0;
            text-align: center;
            letter-spacing: 5px;
            background-color: black;
            color: transparent;
            text-shadow: 2px 2px 3px rgba(255, 255, 255, 0.1);
            -webkit-background-clip: text;
            -moz-background-clip: text;
            background-clip: text;

            span {
                font-size: 1.2em;
            }
        }

        code {
            color: #bdbdbd;
            text-align: left;
            display: block;
            font-size: 16px;
            margin: 0 30px 25px;

            span {
                color: #f0c674;
            }

            i {
                color: #b5bd68;
            }

            em {
                color: #b294bb;
                font-style: unset;
            }

            b {
                color: #81a2be;
                font-weight: 500;
            }
        }


        a {
            color: #8abeb7;
            font-family: monospace;
            font-size: 20px;
            text-decoration: underline;
            margin-top:10px;
            display:inline-block
        }

        @media screen and (max-width: 880px) {
            p {
                font-size: 14vw;
            }
        }
      </style>
    </head>
    <body class="no-skin">
<div style="position:absolute;top:0px;right:0px;bottom:0px;left:0px;background:rgb(40,40,40)">
  <center><p>HTTP: <span>404</span></p></center>
  <div style='padding:10px;margin:auto;width:60%'>
    <code>
      <span>$this->page-></span>not_found = true;
    </code>
    <code>
      <span>if</span> (<b>you_spelt_it_wrong</b>) {<span>try_again()</span>;}
    </code>
    <code>
      <span>else if (<b>we_screwed_up</b>)</span> {<br>
      <em>alert</em>(<i>"We're really sorry about that."</i>); 
      <br>
      <span>window</span>.<em>location</em> = home;<br>}<br>halaman mungkin belum ada...
    </code>
  </div>
</div>     
<script>
  delay_ = 30;
  function type(n, t) {
    var str = document.getElementsByTagName("code")[n].innerHTML.toString();
    var i = 0;
    document.getElementsByTagName("code")[n].innerHTML = "";

    setTimeout(function() {
      var se = setInterval(function() {
        i++;
        document.getElementsByTagName("code")[n].innerHTML =
          str.slice(0, i) + "|";
        if (i == str.length) {
          clearInterval(se);
          document.getElementsByTagName("code")[n].innerHTML = str;
        }
      }, delay_);
    }, t);
  }

  t2 = 70 * delay_ ; //60
  t3 = 150 * delay_ ; //130
  type(0, 0);
  type(1, t2);
  type(2, t3);
/*

*/
</script>