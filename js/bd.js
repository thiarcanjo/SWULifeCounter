/** BD */

/** ASPECTOS */
const aspect = [
    {
        code: "g",
        name: "Command",
        img: "https://swudb.com/images/Command.png"
    },
    {
        code: "b",
        name: "Villainy",
        img: "https://swudb.com/images/Villainy.png"
    },
    {
        code: "w",
        name: "Heroism",
        img: "https://swudb.com/images/Heroism.png"
    },
    {
        code: "y",
        name: "Cunning",
        img: "https://swudb.com/images/Cunning.png"
    },
    {
        code: "b",
        name: "Vigilance",
        img: "https://swudb.com/images/Vigilance.png"
    },
    {
        code: "r",
        name: "Aggression",
        img: "https://swudb.com/images/Aggression.png"
    },
    {
        code: "n",
        name: "None",
        img: ""
    }
];

/** COLLECTIONS */
const collection = [
    {
        code: "SOR",
        name: "Spark of Rebellion"
    },
    {
        code: "SHD",
        name: "Shadows of de Galaxy"
    },
    {
        code: "TWI",
        name: "Twilight of the Republic"
    },
    {
        code: "JTL",
        name: "Jump to Lightspeed"
    }
];

/** OBJ: BASES*/
const base = [
    {
      code: "SOR019",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "019",
      name: "Security Complex",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 25,
      epic: true
    },
    {
      code: "SOR020",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "020",
      name: "Capital City",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 30,
      epic: false
    },
    {
      code: "SOR021",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "021",
      name: "Dagobah Swamp",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 30,
      epic: false
    },
    {
      code: "SOR022",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "022",
      name: "Energy Conversion Lab",
      aspect: aspect[aspect.findIndex(e => e.name === "Command")],
      life: 25,
      epic: true
    },
    {
      code: "SOR023",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "023",
      name: "Command Center",
      aspect: aspect[aspect.findIndex(e => e.name === "Command")],
      life: 30,
      epic: false
    },
    {
      code: "SOR024",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "024",
      name: "Echo Base",
      aspect: aspect[aspect.findIndex(e => e.name === "Command")],
      life: 30,
      epic: false
    },
    {
      code: "SOR025",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "025",
      name: "Tarkintown",
      aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
      life: 25,
      epic: true
    },
    {
      code: "SOR026",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "026",
      name: "Catacombs of Cadera",
      aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
      life: 30,
      epic: false
    },
    {
      code: "SOR027",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "027",
      name: "Kestro City",
      aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
      life: 30,
      epic: false
    },
    {
      code: "SOR028",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "028",
      name: "Jedha City",
      aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
      life: 25,
      epic: true
    },
    {
      code: "SOR029",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "029",
      name: "Administrator's Tower",
      aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
      life: 30,
      epic: false
    },
    {
      code: "SOR030",
      collection: collection[collection.findIndex(e => e.code === "SOR")],
      number: "030",
      name: "Chopper Base",
      aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
      life: 30,
      epic: false
    },
    {
      code: "SHD019",
      collection: collection[collection.findIndex(e => e.code === "SHD")],
      number: "019",
      name: "Remnant Science Facility",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 30,
      epic: false
    },
    {
      code: "SHD020",
      collection: collection[collection.findIndex(e => e.code === "SHD")],
      number: "020",
      name: "Remote Village",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 30,
      epic: false
    },
    {
      code: "SHD021",
      collection: collection[collection.findIndex(e => e.code === "SHD")],
      number: "021",
      name: "Maz Kanata's Castle",
      aspect: aspect[aspect.findIndex(e => e.name === "Command")],
      life: 30,
      epic: false
    },
    {
      code: "SHD022",
      collection: collection[collection.findIndex(e => e.code === "SHD")],
      number: "022",
      name: "Nevarro City",
      aspect: aspect[aspect.findIndex(e => e.name === "Command")],
      life: 30,
      epic: false
    },
    {
      code: "SHD023",
      collection: collection[collection.findIndex(e => e.code === "SHD")],
      number: "023",
      name: "Death Watch Hideout",
      aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
      life: 30,
      epic: false
    },
    {
      code: "SHD024",
      collection: collection[collection.findIndex(e => e.code === "SHD")],
      number: "024",
      name: "Spice Mines",
      aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
      life: 30,
      epic: false
    },
    {
      code: "SHD025",
      collection: collection[collection.findIndex(e => e.code === "SHD")],
      number: "025",
      name: "Coronet City",
      aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
      life: 30,
      epic: false
    },
    {
      code: "SHD026",
      collection: collection[collection.findIndex(e => e.code === "SHD")],
      number: "026",
      name: "Jabba's Palace",
      aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
      life: 30,
      epic: false
    },

    {
      code: "TWI019",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "019",
      name: "Pau City",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 26,
      epic: false
    },
    {
      code: "TWI020",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "020",
      name: "Sundari",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 30,
      epic: false
    },
    {
      code: "TWI021",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "021",
      name: "The Crystal City",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 30,
      epic: false
    },
    {
      code: "TWI022",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "022",
      name: "Droid Manufactory",
      aspect: aspect[aspect.findIndex(e => e.name === "Command")],
      life: 24,
      epic: false
    },
    {
      code: "TWI023",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "023",
      name: "Lair of Grievous",
      aspect: aspect[aspect.findIndex(e => e.name === "Command")],
      life: 30,
      epic: false
    },
    {
      code: "TWI024",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "024",
      name: "Tipoca City",
      aspect: aspect[aspect.findIndex(e => e.name === "Command")],
      life: 30,
      epic: false
    },
    {
      code: "TWI025",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "025",
      name: "Shadow Collective Camp",
      aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
      life: 25,
      epic: false
    },
    {
      code: "TWI026",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "026",
      name: "KCM Mining Facility",
      aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
      life: 30,
      epic: false
    },
    {
      code: "TWI027",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "027",
      name: "The Nest",
      aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
      life: 30,
      epic: false
    },
    {
      code: "TWI028",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "028",
      name: "Petranaki Arena",
      aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
      life: 26,
      epic: false
    },
    {
      code: "TWI029",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "029",
      name: "Level 1313",
      aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
      life: 30,
      epic: false
    },
    {
      code: "TWI030",
      collection: collection[collection.findIndex(e => e.code === "TWI")],
      number: "030",
      name: "Pyke Palace",
      aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
      life: 30,
      epic: false
    },
    {
      code: "JTL019",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "019",
      name: "City in the Clouds",
      aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
      life: 30,
      epic: false
    },
    {
        code: "JTL020",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "020",
        name: "Shield Generator Complex",
        aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
        life: 30,
        epic: false
    },
    {
        code: "JTL021",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "021",
        name: "Colossus",
        aspect: aspect[aspect.findIndex(e => e.name === "Vigilance")],
        life: 35,
        epic: false
    },
    {
        code: "JTL022",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "022",
        name: "Resistance Headquarters",
        aspect: aspect[aspect.findIndex(e => e.name === "Command")],
        life: 30,
        epic: false
    },
    {
        code: "JTL023",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "023",
        name: "Theed Palace",
        aspect: aspect[aspect.findIndex(e => e.name === "Command")],
        life: 30,
        epic: false
    },
    {
        code: "JTL024",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "024",
        name: "Data Vault",
        aspect: aspect[aspect.findIndex(e => e.name === "Command")],
        life: 33,
        epic: false
    },
    {
        code: "JTL025",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "025",
        name: "Thermal Oscillator",
        aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
        life: 27,
        epic: false
    },
    {
        code: "JTL026",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "026",
        name: "Massassi Temple",
        aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
        life: 30,
        epic: false
    },
    {
        code: "JTL027",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "027",
        name: "Nadiri Dockyards",
        aspect: aspect[aspect.findIndex(e => e.name === "Aggression")],
        life: 30,
        epic: false
    },
    {
        code: "JTL028",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "028",
        name: "Nabat Village",
        aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
        life: 27,
        epic: false
    },
    {
        code: "JTL029",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "029",
        name: "Chopper Base",
        aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
        life: 30,
        epic: false
    },
    {
        code: "JTL030",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "030",
        name: "Mos Eisley",
        aspect: aspect[aspect.findIndex(e => e.name === "Cunning")],
        life: 30,
        epic: false
    },
    {
        code: "JTL031",
        collection: collection[collection.findIndex(e => e.code === "JTL")],
        number: "031",
        name: "Lake Country",
        aspect: aspect[aspect.findIndex(e => e.name === "None")],
        life: 34,
        epic: false
    }
  ];

/** OBJ: LIDERS*/
const leader = [
  {
    code: "SOR001",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "001",
    name: "Director Krennic, Aspiring to Authority",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
    code: "SOR002",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "002",
    name: "Iden Versio, Inferno Squad Commander",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
    code: "SOR003",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "003",
    name: "Chewbacca, Walking Carpet",
    cost: 7,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SOR004",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "004",
    name: "Chirrut Îmwe, One With The Force",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SOR005",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "005",
    name: "Luke Skywalker, Faithful Friend",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SOR006",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "006",
    name: "Emperor Palpatine, Galactic Ruler",
    cost: 8,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SOR007",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "007",
    name: "Grand Moff Tarkin, Oversector Governor",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SOR008",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "008",
    name: "Hera Syndulla, Spectre Two",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SOR009",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "009",
    name: "Leia Organa, Alliance General",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SOR010",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "010",
    name: "Darth Vader, Dark Lord of the Sith",
    cost: 7,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SOR011",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "011",
    name: "Grand Inquisitor, Hunting the Jedi",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SOR012",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "012",
    name: "IG-88, Ruthless Bounty Hunter",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SOR013",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "013",
    name: "Cassian Andor, Dedicated to the Rebellion",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SOR014",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "014",
    name: "Sabine Wren, Galvanized Revolutionary",
    cost: 4,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SOR015",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "015",
    name: "Boba Fett, Collecting the Bounty",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SOR016",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "016",
    name: "Grand Admiral Thrawn, Patient and Insightful",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SOR017",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "017",
    name: "Han Solo, Audacious Smuggler",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SOR018",
    collection: collection[collection.findIndex(e => e.code === "SOR")],
    number: "018",
    name: "Jyn Erso, Resisting Oppression",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD001",
    collection: collection[collection.findIndex(e => e.code === "SHD")], // Assuming you have a 'collection' array
    number: "001",
    name: "Gar Saxon, Viceroy of Mandalore",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Villainy")]] // Assuming you have an 'aspect' array
  },
  {
    code: "SHD002",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "002",
    name: "Qi'ra, I Alone Survived",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SHD003",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "003",
    name: "Finn, This Is A Rescue",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD004",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "004",
    name: "Rey, More Than A Scavenger",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD005",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "005",
    name: "Hondo Ohnaka, That's Good Business",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SHD006",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "006",
    name: "Jabba the Hutt, His High Exaltedness",
    cost: 7,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SHD007",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "007",
    name: "Moff Gideon, Formidable Commander",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SHD008",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "008",
    name: "Boba Fett, Daimyo",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD009",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "009",
    name: "Hunter, Outcast Sergeant",
    cost: 7,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD010",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "010",
    name: "Bossk, Hunting His Prey",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SHD011",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "011",
    name: "Kylo Ren, Rash and Deadly",
    cost: 4,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SHD012",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "012",
    name: "Bo-Katan Kryze, Princess In Exile",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD013",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "013",
    name: "Han Solo, Worth the Risk",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD014",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "014",
    name: "Cad Bane, He Who Needs No Introduction",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SHD015",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "015",
    name: "Doctor Aphra, Rapacious Archaeologist",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "SHD016",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "016",
    name: "Fennec Shand, Honoring the Deal",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD017",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "017",
    name: "Lando Calrissian, With Impeccable Taste",
    cost: 4,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "SHD018",
    collection: collection[collection.findIndex(e => e.code === "SHD")],
    number: "018",
    name: "The Mandalorian, Sworn to the Creed",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "TWI001",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "001",
    name: "Nala Se, Clone Engineer",
    cost: 4,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI002",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "002",
    name: "Nute Gunray, Vindictive Viceroy",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI003",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "003",
    name: "Obi-Wan Kenobi, Patient Mentor",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "TWI004",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "004",
    name: "Yoda, Sensing Darkness",
    cost: 7,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "TWI005",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "005",
    name: "Count Dooku, Face of the Confederacy",
    cost: 7,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI006",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "006",
    name: "Wat Tambor, Techno Union Foreman",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI007",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "007",
    name: "Captain Rex, Fighting for his Brothers",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "TWI008",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "008",
    name: "Padmé Amidala, Serving the Republic",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "TWI009",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "009",
    name: "Maul, A Rival in Darkness",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI010",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "010",
    name: "Pre Vizsla, Pursuing the Throne",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI011",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "011",
    name: "Ahsoka Tano, Snips",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "TWI012",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "012",
    name: "Anakin Skywalker, What It Takes To Win",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "TWI013",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "013",
    name: "Mace Windu, Vaapad Form Master",
    cost: 7,
    aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "TWI014",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "014",
    name: "Asajj Ventress, Unparalleled Adversary",
    cost: 4,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI015",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "015",
    name: "General Grievous, General of the Droid Armies",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI016",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "016",
    name: "Jango Fett, Concealing the Conspiracy",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI017",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "017",
    name: "Chancellor Palpatine, Playing Both Sides",
    cost: 0,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")], aspect[aspect.findIndex(e => e.name === "Villainy")]]
  },
  {
    code: "TWI018",
    collection: { code: "TWI", name: "Twin Suns" },
    number: "018",
    name: "Quinlan Vos, Sticking the Landing",
    cost: 5,
    aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]]
  },
  {
    code: "JTL001",
    collection: collection[collection.findIndex(e => e.code === "JTL")],
    number: "001",
    name: "Asajj Ventress",
    cost: 6,
    aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL002",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "002",
      name: "Grand Admiral Thrawn",
      cost: 6,
      aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL003",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "003",
      name: "Lando Calrissian",
      cost: 7,
      aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  },
  {
      code: "JTL004",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "004",
      name: "Rose Tico",
      cost: 5,
      aspect: [aspect[aspect.findIndex(e => e.name === "Vigilance")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  },
  {
      code: "JTL005",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "005",
      name: "Admiral Piett",
      cost: 5,
      aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL006",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "006",
      name: "Darth Vader",
      cost: 6,
      aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL007",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "007",
      name: "Admiral Holdo",
      cost: 6,
      aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  },
  {
      code: "JTL008",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "008",
      name: "Wedge Antilles",
      cost: 5,
      aspect: [aspect[aspect.findIndex(e => e.name === "Command")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  },
  {
      code: "JTL009",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "009",
      name: "Boba Fett",
      cost: 6,
      aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL010",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "010",
      name: "Captain Phasma",
      cost: 5,
      aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL011",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "011",
      name: "Major Vonreg",
      cost: 4,
      aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL012",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "012",
      name: "Luke Skywalker",
      cost: 6,
      aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  },
  {
      code: "JTL013",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "013",
      name: "Poe Dameron",
      cost: 5,
      aspect: [aspect[aspect.findIndex(e => e.name === "Aggression")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  },
  {
      code: "JTL014",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "014",
      name: "Admiral Trench",
      cost: 6,
      aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL015",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "015",
      name: "Rio Durant",
      cost: 5,
      aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Villainy")]],
  },
  {
      code: "JTL016",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "016",
      name: "Admiral Ackbar",
      cost: 6,
      aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  },
  {
      code: "JTL017",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "017",
      name: "Han Solo",
      cost: 5,
      aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  },
  {
      code: "JTL018",
      collection: collection[collection.findIndex(e => e.code === "JTL")],
      number: "018",
      name: "Kazuda Xiono",
      cost: 4,
      aspect: [aspect[aspect.findIndex(e => e.name === "Cunning")], aspect[aspect.findIndex(e => e.name === "Heroism")]],
  }
];