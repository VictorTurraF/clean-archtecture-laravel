<style>

.main {
    width: 100%;
}

.card {
    border-radius: 1.5rem;
    overflow: hidden;
    background: #0c6;
    max-width: 430px;
    color: #fff;
}

.card-header {
    background: #00994d;
    color: #fff;
    font-size: 2.5rem;
    padding: 1rem 3rem;
}

.card-body {
  padding: 1rem 3rem;
}

.section {
  padding: 1.5rem 3rem;
  background: #00b359;
}

.section .date {
  font-size: 2rem;
  font-weight: 800;
}

p {
  font-size: 18px;
  margin: 0;
}

.results-grid {
  display: grid;
  grid-template-columns: 1fr auto;
  grid-template-rows: 3rem;
  grid-auto-rows: 3rem;
  color: #00331a;
  background: #ccffe6;
  padding: 1rem 0;
}

.results-grid .label {
  display: flex;
  justify-content: start;
  font-weight: 700;
}

.results-grid .value {
  display: flex;
  justify-content: end;
}

.cell {
  padding: 0 3rem;
  display: flex;
  align-items: center;
}
</style>

<div class="main">
    <div class="card">
        <div class="card-header">
            Olá, {{ $sellerName }}
        </div>
        <div class="card-body">
          <p>Esse foram os seus resultados na data de hoje</p>
        </div>
        <div class="section">
          <span class="date">{{ $reportDate }}</span>
        </div>
        <div class="results-grid">
          <div class="cell label">Total em vendas</div>
          <div class="cell value">{{ $totalSold }}</div>
          <div class="cell label">Total de commissão</div>
          <div class="cell value">{{ $totalCommission }}</div>
        </div>
    </div>
</div>

