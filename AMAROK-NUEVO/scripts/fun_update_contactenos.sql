CREATE OR REPLACE FUNCTION fun_update_contactenos( wid_contactenos	contactenos.contacId%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wcontac contactenos.contacId%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT contacId INTO wcontac FROM contactenos WHERE contacId=wid_contactenos FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El registro no se encuentra registrado';
            RETURN wmessage;
        END IF;
        UPDATE contactenos SET contacRev = TRUE 
        WHERE contacId = wid_contactenos;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;