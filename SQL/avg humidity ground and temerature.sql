SELECT AVG( s.humidity_ground )  AS average_humidity_ground
     , AVG( s.temperature )      AS average_temperature
	 , CASE DATE( s.created_at )
	     WHEN CURRENT_DATE THEN
		   'today'
		 WHEN DATE( CURRENT_DATE, '-1 days' ) THEN
		   'yesterday'
		 ELSE
		   'day out of timerange'
	   END                       AS day
FROM sensor AS s

WHERE DATE( s.created_at ) BETWEEN DATE( CURRENT_DATE, '-1 days' ) AND CURRENT_DATE

GROUP BY DATE( s.created_at );