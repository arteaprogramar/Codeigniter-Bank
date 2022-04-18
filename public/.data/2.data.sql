	
    USE alcala;
    
    SELECT * FROM users;
    INSERT INTO users(id, name, first_name, clabe, pin) VALUES (1, 'Bruno', 'Díaz', 3421, 1234); 
    
    SELECT * FROM balances;
    INSERT INTO balances(id, id_user, balance) VALUES (1, 1, 0);
    
    SELECT * FROM type_request;
    INSERT INTO type_request(id, name) VALUES(1, 'Ingresa Efectivo');
    INSERT INTO type_request(id, name) VALUES(2, 'Retirar Efectivo');
    INSERT INTO type_request(id, name) VALUES(3, 'Transferencia');
    INSERT INTO type_request(id, name) VALUES(4, 'Recarga Telefonica');
    INSERT INTO type_request(id, name) VALUES(5, 'Saldo');
    
    SELECT * FROM request;
    
    SELECT DISTINCT * FROM users u
    INNER JOIN balances b ON b.id_user = u.id
    INNER JOIN request s ON s.id_sender = b.id
    INNER JOIN type_request ty ON ty.id = s.id_type
    WHERE u.id = 2;
    