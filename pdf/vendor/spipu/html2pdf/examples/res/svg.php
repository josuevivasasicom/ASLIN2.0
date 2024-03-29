<style type="text/css">
.main-draw {
    margin: auto;
    background: #000000;
    border: solid 0.5mm var(--color-main);
    width:150mm;
    height:100mm;
}

.full-stroke {
    stroke-width:1mm;
}

.middle-stroke {
    stroke-width:0.5mm;
}
</style>
<page>
    <draw class="main-draw">
        <line    class="full-stroke" style="stroke:#FF0000;" x1="10mm" y1="10mm" x2="140mm" y2="10mm" >
        <rect    class="full-stroke" style="stroke:#770077; fill:#008888" x="15%" y="15%"  w="70%" h="70%">
        <ellipse class="full-stroke" style="stroke:#000077; fill:#888800" cx="50%" cy="50%" rx="30%" ry="30%">
        <circle  class="full-stroke" style="stroke:#0000AA; fill:#AAAA00" cx="50%" cy="50%" r="15%">
    </draw><br>
    <draw class="main-draw">
        <path class="full-stroke"   style="fill:#AAAA00; stroke:#0000AA;" d="M20mm,10mm H130mm A10mm,10mm 0,0,0 140mm,20mm V80mm A10mm,10mm 0,0,0 130mm,90mm H20mm A10mm,10mm 0,0,0 10mm,80mm V20mm A10mm,10mm 0,0,0 20mm,10mm">
        <path class="middle-stroke" style="fill:#770000; stroke:#AA0033;" d="M 20mm,40mm a16mm,8mm 0,0,0 16mm,8mm" />
        <path class="middle-stroke" style="fill:#770000; stroke:#00AA33;" d="M 20mm,40mm l16mm,8mm" />
        <path class="middle-stroke" style="fill:#770000; stroke:#AA0033;" d="M 40mm,40mm a16mm,8mm 0,0,1 16mm,8mm" />
        <path class="middle-stroke" style="fill:#770000; stroke:#00AA33;" d="M 40mm,40mm l16mm,8mm" />
        <path class="middle-stroke" style="fill:#770000; stroke:#AA0033;" d="M 80mm,40mm a16mm,8mm 0,1,0 16mm,8mm" />
        <path class="middle-stroke" style="fill:#770000; stroke:#00AA33;" d="M 80mm,40mm l16mm,8mm" />
        <path class="middle-stroke" style="fill:#770000; stroke:#AA0033;" d="M100mm,40mm a16mm,8mm 0,1,1 16mm,8mm" />
        <path class="middle-stroke" style="fill:#770000; stroke:#00AA33;" d="M100mm,40mm l16mm,8mm" />
    </draw><br>
    <br>
    Les balises SVG suivantes sont reconnues : LINE, RECT, CIRCLE, ELLIPSE, PATH, POLYGON, POLYLINE, G<br>
    <br>
    Spécifications SVG : <a href="http://www.w3.org/TR/SVG11/expanded-toc.html">http://www.w3.org/TR/SVG11/expanded-toc.html</a>
</page>