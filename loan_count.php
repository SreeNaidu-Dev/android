<?php
// Include the database connection
include "db.php";

// Get the loan type from the query parameter
$loanType = isset($_GET['type']) ? $_GET['type'] : '';

// Validate input
if (!empty($loanType)) {
    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT COUNT(*) AS loan_count FROM custome WHERE loan_type = ?");
    $stmt->bind_param("s", $loanType);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check and display the result
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($loanType === "personal loan") {
            echo "<h3>Personal Loan Count: " . $row['loan_count'] . "</h3>";
        } else {
            echo "<h3>Total " . ucfirst($loanType) . "s: " . $row['loan_count'] . "</h3>";
        }
    } else {
        echo "<h3>No " . ucfirst($loanType) . "s found</h3>";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<h3>Invalid loan type</h3>";
}

// Close the connection
$conn->close();
?>
