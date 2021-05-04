   
<link rel="stylesheet" type="text/css" href="<?=Yii::app()->createUrl('/js');?>orbjs/dist/orb.css" />
<script type="text/javascript" src="<?=Yii::app()->createUrl('/js');?>orbjs/deps/react-0.12.2.js"></script>
<script type="text/javascript" src="<?=Yii::app()->createUrl('/js');?>orbjs/dist/orb.js"></script>	
	<!-- ***** -->

<script type="text/javascript" src="<?=Yii::app()->createUrl('/js');?>orbjs/demo/demo.data.js"></script>

    <style type="text/css">
    div#rr{        
        font-size: 13px;
    }
    
    div#rr td{
        padding: 5px;
    }
    </style>

    <h4 style="margin-top: 2em; text-align: center">Rekapitulasi Penataan Batas Blok Periode RKT <?=$tahun;?></h4>
    <div id="rr" style="padding: 7px;"></div>
    <div id="export" style="padding: 7px;"></div>

    <script type="text/javascript">

    function exportToExcel(anchor) {
        anchor.href = orb.export(pgridwidget);
        return true;
    }

    var config = {
        dataSource: window.demo.data,
        canMoveFields: true, 
        dataHeadersLocation: 'columns',
        //width: 1099,
        //height: 611,
        theme: 'blue',
        toolbar: {
            visible: true
        },
        grandTotal: {
            rowsvisible: false,
            columnsvisible: false
        },
        subTotal: {
            visible: true,
            collapsed: true,
            collapsible: true
        },
        rowSettings: {
            subTotal: {
                visible: true,
                collapsed: true,
                collapsible: true
            }
        },
        columnSettings: {
            subTotal: {
                visible: false,
                collapsed: true,
                collapsible: true
            }
        },
        fields: [
            {
                name: '6',
                caption: 'Amount',
                dataSettings: {
                    aggregateFunc: 'sum',
                    aggregateFuncName: 'whatever',
                    formatFunc: function(value) {
                        return value ? Number(value).toFixed(0) + ' $' : '';
                    }
                }
            },
            {
                name: '0',
                caption: 'Entity'
            },
            {
                name: '1',
                caption: 'Product',
            },
            {
                name: '2',
                caption: 'Manufacturer',
                sort: {
                    order: 'asc'
                },
                rowSettings: {
                    subTotal: {
                        visible: false,
                        collapsed: true,
                        collapsible: true
                    }
                },
            },
            {
                name: '3',
                caption: 'Class'
            },
            {
                name: '4',
                caption: 'Category',
                sort: {
                    order: 'desc'
                }
            },
            {
                name: '5',
                caption: 'Quantity',
                aggregateFunc: 'sum'
            }
        ],
        rows    : [ 'Manufacturer'],//, 'Category' ],
        columns : [ 'Class', 'Category' ],
        data    : [ 'Quantity', 'Amount' ],
        /*preFilters : {
            'Class': { 'Matches': 'Regular' },
            'Manufacturer': { 'Matches': /^a|^c/ },
            'Category'    : { 'Does Not Match': 'D' },
           // 'Amount'      : { '>':  40 },
         //   'Quantity'    : [4, 8, 12]
        }*/
    };

    var elem = document.getElementById('rr')

    var pgridwidget = new orb.pgridwidget(config);
    pgridwidget.render(elem);

    </script>