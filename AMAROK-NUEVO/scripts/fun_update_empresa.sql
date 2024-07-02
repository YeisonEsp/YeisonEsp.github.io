CREATE OR REPLACE FUNCTION fun_update_empresa(  wnit_empresa empresatransporte.empreTraNit%TYPE, 
                                                wnom_empresa empresatransporte.empreTraNom%TYPE, 
												wtel_empresa empresatransporte.empreTraTel%TYPE,wuser_update empresatransporte.usr_update%TYPE,
                                                wuser_update_rol  empresatransporte.usr_update_rol%TYPE) RETURNS VARCHAR AS      
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wempresa empresatransporte.empreTraNit%TYPE;
    BEGIN
        wmessage='00000';
        SELECT empreTraNit INTO wempresa FROM empresatransporte WHERE empreTraNit = wnit_empresa FOR UPDATE;
        UPDATE empresatransporte SET    empreTraNit       = wnit_empresa,
                                        empreTraNom       = wnom_empresa,
                                        empreTraTel       = wtel_empresa,
                                        usr_update        = wuser_update,
                                        usr_update_rol    = wuser_update_rol,
                                        fec_update        = now()
        WHERE empreTraNit = wnit_empresa;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage='Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;