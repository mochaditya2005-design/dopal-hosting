import { Pool } from 'pg';

const pool = new Pool({
  connectionString: process.env.DATABASE_URL,
});

export async function POST(req) {
  try {
    const body = await req.json();

    const { nama, email, layanan, paket, catatan } = body;

    // validasi sederhana
    if (!nama || !email) {
      return Response.json(
        { success: false, error: "Nama dan email wajib diisi" },
        { status: 400 }
      );
    }

    // insert ke database
    const result = await pool.query(
      `INSERT INTO orders (nama, email, layanan, paket, catatan)
       VALUES ($1, $2, $3, $4, $5)
       RETURNING id`,
      [nama, email, layanan, paket, catatan]
    );

    const order_id = result.rows[0].id;

    // format pesan WhatsApp
    const pesan = `Order Baru Dopal Hosting

Nama: ${nama}
Email: ${email}
Layanan: ${layanan}
Paket: ${paket}
Catatan: ${catatan}`;

    // kirim WA via Fonnte
    await fetch("https://api.fonnte.com/send", {
      method: "POST",
      headers: {
        "Authorization": process.env.FONNTE_API_KEY
      },
      body: new URLSearchParams({
        target: "6285607598817",
        message: pesan
      })
    });

    return Response.json({
      success: true,
      order_id: order_id
    });

  } catch (error) {
    console.error(error);

    return Response.json(
      { success: false, error: error.message },
      { status: 500 }
    );
  }
}
