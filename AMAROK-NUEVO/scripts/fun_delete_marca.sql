CREATE OR REPLACE FUNCTION fun_delete_marca( wid_marca	marca.marcaId%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmar marca.marcaId%TYPE;
    DECLARE wmessage VARCHAR;
    DECLARE wmarca marca.marcaId%TYPE;
    BEGIN
        wmessage='00000';
        SELECT marcaId INTO wmarca FROM marca WHERE marcaId=wid_marca FOR UPDATE;
        SELECT idmarca INTO wmar FROM producto WHERE idmarca=wid_marca;
        IF  NOT FOUND THEN
            DELETE FROM marca
            WHERE marcaId = wid_marca;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage='Error al eliminar';
                RETURN wmessage;
            END IF;
        ELSE
            wmessage='La marca no se puede eliminar porque está asociada a algún producto';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;