<!DOCTYPE html>
 <html>
 <head>
     <title>Data Supplier</title>
 </head>
 <body>
     <h1>Data Supplier</h1>
     <table border="1" cellpadding="2" cellspacing="0">
         <tr>
             <th>Supplier ID</th>
             <th>Kode Supplier</th>
             <th>Nama Supplier</th>
             <th>Alamat Supplier</th>
             <th>No HP Supplier</th>
         </tr>
         @foreach ($data as $d)
         <tr>
             <td>{{ $d->supplier_id }}</td>
             <td>{{ $d->supplier_kode }}</td>
             <td>{{ $d->supplier_nama }}</td>
             <td>{{ $d->supplier_alamat }}</td>
             <td>{{ $d->supplier_no_hp }}</td>
         </tr>
         @endforeach
     </table>
 </body>
 </html>