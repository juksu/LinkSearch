CREATE TABLE url (
    address CHAR(100),
    CONSTRAINT url_PK PRIMARY KEY (address)
);

CREATE TABLE linksto (
    sourcepage CHAR(100),
    link CHAR(100),
    CONSTRAINT linksto_PK PRIMARY KEY (sourcepage , link),
    CONSTRAINT linksto_FK_source FOREIGN KEY (sourcepage)
        REFERENCES url(address) ON DELETE CASCADE,
    CONSTRAINT linksto_FK_link FOREIGN KEY (link)
        REFERENCES url(address) ON DELETE CASCADE
);
