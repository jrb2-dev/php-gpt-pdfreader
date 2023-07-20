<?php
function chunk_text_file( $filename, $chunk_size = 4000, $overlap = 1000 ) {
    // Check if file exists
    if (!file_exists($filename)) {
        throw new \Exception("File does not exist.");
    }

    if( $overlap > $chunk_size ) {
        throw new \Exception( "Overlap must be smaller than chunk size" );
    }

    $chunks = [];

    $file = fopen( $filename, "r" );
    if ($file === false) {
        throw new \Exception("Could not open the file.");
    }

    while( ! feof( $file ) ) {
        $chunk = fread( $file, $chunk_size );
        $chunks[] = $chunk;
        if( feof( $file ) ) {
            break;
        }
        fseek( $file, -$overlap, SEEK_CUR );
    }

    fclose($file);  // Close the file after reading

    return $chunks;
}
