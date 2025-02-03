( function( wp ) {
    const { registerBlockType } = wp.blocks;
    const { useState, useEffect } = wp.element;
    const { Button, Spinner } = wp.components;

    registerBlockType('wp-miusage-api-block/block', {
        title: 'MiUsage API Block',
        icon: 'editor-table',
        category: 'widgets',
        edit: function() {
            const [apiData, setApiData] = useState(null);
            const [loading, setLoading] = useState(true);

            const fetchData = () => {
                setLoading(true);
                fetch( ajaxurl + '?action=get_miusage_data' )
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("API Data Loaded:", data);
                            setApiData(data.data);
                        } else {
                            console.error("API Error:", data);
                        }
                        setLoading(false);
                    })
                    .catch(error => console.error("Fetch Error:", error));
            };

            useEffect(() => {
                fetchData();
            }, []);

            if (loading) {
                return wp.element.createElement( Spinner, null );
            }

            return wp.element.createElement(
                'div',
                { className: 'miusage-api-block' },
                wp.element.createElement('h2', null, apiData?.title),
                wp.element.createElement(
                    'table',
                    null,
                    wp.element.createElement(
                        'thead',
                        null,
                        wp.element.createElement(
                            'tr',
                            null,
                            apiData?.data?.headers.map((header, index) =>
                                wp.element.createElement('th', { key: index }, header)
                            )
                        )
                    ),
                    wp.element.createElement(
                        'tbody',
                        null,
                        Object.keys(apiData?.data?.rows || {}).map((rowKey) => {
                            const row = apiData.data.rows[rowKey];
                            return wp.element.createElement(
                                'tr',
                                { key: row.id },
                                wp.element.createElement('td', null, row.id),
                                wp.element.createElement('td', null, row.fname),
                                wp.element.createElement('td', null, row.lname),
                                wp.element.createElement('td', null, row.email),
                                wp.element.createElement('td', null, new Date(row.date * 1000).toLocaleString())
                            );
                        })
                    )
                ),
                wp.element.createElement(
                    Button,
                    { isSecondary: true, onClick: fetchData },
                    'Refresh Data'
                )
            );
        },
        save: function() {
            return null;
        }
    });

} )( window.wp );
