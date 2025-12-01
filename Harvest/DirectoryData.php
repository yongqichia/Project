<?php
// Establish database connection
$dbConnection = mysqli_connect('localhost', 'root', '', 'harvest_db'); // Ensure the database name is correct

if (!$dbConnection) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Delete all existing rows from the workshops table
$delete_sql = "DELETE FROM directory";
if (mysqli_query($dbConnection, $delete_sql)) {
    echo "Previous workshop data deleted successfully.<br>";
} else {
    echo "Error deleting data: " . mysqli_error($dbConnection) . "<br>";
}

// Insert sample data into the 'directory' table
$insert_sql = "INSERT INTO directory (name, address, operation_time, contact_number, type, details_link)
VALUES
    ('Malaysia Food Bank', '123 Jalan Food, Kuala Lumpur, Malaysia', 'Mon-Fri: 9 AM - 5 PM', '012-3456789', 'Food Distribution', 'https://foodbankmalaysia.com/'),
    ('Kechara Soup Kitchen', '17, Jalan Barat,Off Jalan Imbi,55100 Kuala Lumpur, Kuala Lumpur, Malaysia', 'Daily: 10 AM - 8 PM', '011-2233445', 'Soup Kitchen', 'https://kecharasoupkitchen.com/'),
    ('Kechara Food Bank', '17, Jalan Barat,Off Jalan Imbi,55100 Kuala Lumpur, Kuala Lumpur, Malaysia', 'Mon-Sat: 8 AM - 6 PM', '017-1122334', 'Food Distribution', 'https://kecharasoupkitchen.com/'),
    ('Komune Care Centre', 'Komune Living and Wellness, 21, Jalan Tasik Permaisuri 2, Bandar Tun Razak, 56000, Kuala Lumpur, Malaysia.', 'Mon-Fri: 10 AM - 4 PM', '03-9078 2626', 'Care Services', 'https://komunecare.com/?utm_source=adwords&utm_medium=ppc&utm_campaign=Komune%20CARE%20-%20Leads%20-%20Max%20Clicks&utm_term=senior%20care%20malaysia&hsa_acc=8960599693&hsa_cam=15269973769&hsa_grp=128431990463&hsa_ad=650013263726&hsa_src=g&hsa_tgt=kwd-326144947102&hsa_kw=senior%20care%20malaysia&hsa_mt=b&hsa_net=adwords&hsa_ver=3&gclid=Cj0KCQiAgdC6BhCgARIsAPWNWH0J5VwG71De2bV3hQ-lUTTpBQ9qiDwlcH88_EjqtoNRQcAM-NBxPfsaAvOxEALw_wcB'),
    ('World Vision Malaysia', '532, Block A, Kelana Centre Point, Jalan SS 7/19, SS7, 47301 Petaling Jaya, Selangor', 'Mon-Sun: 9 AM - 7 PM', '019-3344556', 'Food Distribution', 'https://www.worldvision.com.my/en/sponsor-a-child/light-up-a-child-world-this-christmas?mc=15506&utm_term=non%20profit&utm_campaign=1000+Girls+CS+GENERIC+(SEM)&utm_source=adwords&utm_medium=ppc&hsa_acc=9466289323&hsa_cam=20371053484&hsa_grp=157948847731&hsa_ad=721538299610&hsa_src=g&hsa_tgt=kwd-10219146&hsa_kw=non%20profit&hsa_mt=b&hsa_net=adwords&hsa_ver=3&gad_source=1&gclid=Cj0KCQiAgdC6BhCgARIsAPWNWH3bTxoE6zqz7alJ1GrTmmiXWsT6G5rnQXxxO9xHiEh4hMPkKpLR-WEaAqO-EALw_wcB')
    
";

// Check if the query runs successfully
if (mysqli_query($dbConnection, $insert_sql)) {
    echo "Sample data inserted successfully<br>";
} else {
    if (mysqli_errno($dbConnection) == 1062) {
        echo "Duplicate entry detected. Data already exists in the table.<br>";
    } else {
        echo "Error inserting data: " . mysqli_error($dbConnection) . "<br>";
    }
}

// Close the database connection
mysqli_close($dbConnection);
?>
