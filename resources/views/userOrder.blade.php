<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sticky Columns - Dynamic Alignment</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .table-container {
      overflow-x: auto;
      max-width: 100%;
      border: 1px solid #ddd;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      table-layout: fixed; /* Ensures consistent column widths */
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    /* Define dynamic widths for sticky columns */
    :root {
      --sticky-col-1-width: 150px;
      --sticky-col-2-width: 100px;
    }

    th.sticky-1, td.sticky-1 {
      position: sticky;
      left: 0;
      width: var(--sticky-col-1-width); /* Use dynamic width */
      background-color: #f8f8f8;
      z-index: 2;
    }

    th.sticky-2, td.sticky-2 {
      position: sticky;
      left: var(--sticky-col-1-width); /* Set based on the first column's width */
      width: var(--sticky-col-2-width);
      background-color: #f8f8f8;
      z-index: 2;
    }

    th.sticky-1 {
      z-index: 3; /* Ensure the header has a higher priority */
    }

    th.sticky-2 {
      z-index: 3; /* Ensure the header has a higher priority */
    }
  </style>
</head>
<body>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th class="sticky-1">Name</th>
          <th class="sticky-2">Age</th>
          <th>City</th>
          <th>Country</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="sticky-1">John Doe</td>
          <td class="sticky-2">25</td>
          <td>New York</td>
          <td>USA</td>
          <td>johndoe@example.com</td>
        </tr>
        <tr>
          <td class="sticky-1">Jane Smith</td>
          <td class="sticky-2">30</td>
          <td>London</td>
          <td>UK</td>
          <td>janesmith@example.com</td>
        </tr>
        <tr>
          <td class="sticky-1">Alice Johnson</td>
          <td class="sticky-2">28</td>
          <td>Toronto</td>
          <td>Canada</td>
          <td>alicejohnson@example.com</td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
