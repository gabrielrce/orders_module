function downloadXML(_data) {
    $.ajax({
        url: '/api/order/' + _data,
        method: 'GET',
        success: function(data) {
            data.forEach(item => {
                const blob = new Blob([item.content], { type: 'application/xml' });
                const url = window.URL.createObjectURL(blob);

                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = item.filename; // Usa el nombre de archivo de cada producto

                document.body.appendChild(a);
                a.click();

                window.URL.revokeObjectURL(url);
            });
        },
        error: function(xhr, status, error) {
            alert('Error:', error);
        }
    });
}


function downloadPDF(orderId) {
    const url = '/api/orderPDF/' + orderId; 

    const a = document.createElement('a');
    a.href = url;
    a.target = '_blank';
    a.download = 'order_' + orderId + '.pdf'; 

    document.body.appendChild(a);
    a.click();

    document.body.removeChild(a);
}

function deleteOrder(orderId) {
    $.ajax({
        url: '/api/deleteOrder/' + orderId,
        method: 'DELETE',
        success: function(data) {
            alert('Borrado con exito')
        },
        error: function(xhr, status, error) {
            alert('Error:', error);
        }
    });   
}