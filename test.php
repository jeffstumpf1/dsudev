<?php
    $pdf = pdf_new();
    pdf_open_file($pdf);
    pdf_set_info($pdf,"Creator","images.php");
    pdf_set_info($pdf,"Title","Horizontal and Vertical Example");
    // Width of 612, and length of 792 make US Letter Size
    // Dimensions are reversed for Landscape Mode
    pdf_begin_page($pdf,792,612);

    pdf_set_font($pdf, "Helvetica-Oblique", 18, "host");
    pdf_show_xy($pdf, "This is horizontal text",50, 300);
    pdf_rotate($pdf, 90); /* rotate coordinates */
    pdf_show_xy($pdf,"vertical text",300, -400);
   
    pdf_rotate($pdf, -90); /* rotate coordinates */;
    pdf_show_xy($pdf, "This is horizontal text",50, 400);

    pdf_end_page($pdf);
    pdf_close($pdf);
    $buf = pdf_get_buffer($pdf);
    $len = strlen($buf);
    Header("Content-type: application/pdf");
    Header("Content-Length: $len");
    Header("Content-Disposition: inline; filename=images.pdf");
    echo $buf;
    pdf_delete($pdf);
?>