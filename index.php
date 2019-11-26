<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>PDFs from your WordPress Media Library</title>
<link rel="stylesheet" href="https://cdn.ncsu.edu/brand-assets/bootstrap/css/bootstrap.min.css">
<style>
    a {
        text-decoration: underline;
    }
    a:hover, a:focus, a:active {
        text-decoration: none;
    }
    tr {
        border-bottom: solid 1px #ccc;
    }
    th, td {
        padding: 1rem;
    }
</style>
</head>

<?php

    $request = $_GET;
    $website = $request['url'];

?>

<body>
    
    <div class="container">
        
        <h1>PDFs from your WordPress Media Library</h1>
        
        <p>Happy <strong>Great PDF Purge of 2019!</strong></p>
        
        <p>If your WordPress website has the REST API enabled (which should be true by default), you can use the tool below to generate a concise list of PDFs stored in your Media Library.</p>
        
        <p>(Note that this tool will only retrieve up to 1,000 PDFs. If you have more than 1,000 PDFs in a single website's Media Library, contact the Accessibility Coordinator for more guidance.)</p>
        
        <p>If this tool does not successfully generate a list of PDFs, it's possible that:</p>
        
        <ul>
            <li>Your website is blocking REST API requests, possibly as a security measure.</li>
            <li>Your website doesn't have any PDFs in the Media Library! Great job!</li>
            <li>The connection timed out. Try again, or contact the Accessibility Coordinator for guidance.</li>
        </ul>
        
        <form action="/pdfpurge">
            <label for="url">Website URL</label><br />
            <span>(eg. <em>oit.ncsu.edu</em>. Do not include the "https://".)</span><br />
            <input type="text" name="url" value="<?php if ( $website ) { echo $website; } ?>" /><br />
            <input type="submit" value="Generate PDF list">
        </form>
        <br />
        <hr />
        <br />

<?php

function read_external_data( $url ) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}



if ( $website ) {
    $continue = true;
    $i = 1;


    $pdfs = array();
    
    while ( $i <= 10 ) {
        $json = read_external_data( 'https://'. $website .'/wp-json/wp/v2/media?mime_type=application/pdf&per_page=100&page=' . $i );
        
        $arr = json_decode( $json );
        
        foreach ( $arr as $pdf ) {
            
            if ( $pdf->source_url ) {
                $pdfs[] = array(
                    'title' => $pdf->title->rendered,
                    'date'  => $pdf->date,
                    'url'   => $pdf->source_url,
                );
            }
            
        }
        
        $i++;
        
    }
    
    $table = '<table><thead><tr><th>Name of PDF</th><th>Date Uploaded</th><th>URL of PDF</th></tr></thead><tbody>';
    
    foreach ( $pdfs as $pdf ) {
        $table .= sprintf(
                '<tr><td>%s</td><td>%s</td><td><a href="%s">%s</a></td></tr>',
                $pdf['title'],
                $pdf['date'],
                $pdf['url'],
                $pdf['url']
            );
    }
    
    $table .= '</tbody></table>';
    
    echo $table;
}




?>

    </div>

</body>
</html>

